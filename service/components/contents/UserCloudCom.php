<?php

namespace service\components\contents;

use yii\base\Exception;
use \GuzzleHttp\Client;
use \GuzzleHttp\Cookie\SetCookie;
use \GuzzleHttp\Cookie\CookieJar;

/**
 * usercloud.com content
 */
class UserCloudCom extends HttpContent
{
    private $proxy;
    private $userAgent;
    private $authCookies;

    /**
     * Returns user agent string
     *
     * @return string
     */
    private function getUserAgent()
    {
        if ($this->userAgent === null) {
            $this->userAgent = $this->getRandomUserAgent();
        }

        return $this->userAgent;
    }

    /**
     * Returns proxy URL
     *
     * @return string
     */
    private function getProxy()
    {
        if ($this->proxy === null) {
            $this->proxy = $this->getRandomProxy();
        }

        return $this->proxy;
    }

    /**
     * Returns HTTP client
     *
     * @return \GuzzleHttp\Client
     */
     private function getHttpClient()
     {
         $client = new Client();

         $instance = \Yii::$app->service->instance;
         if ($instance->isProxyEnabled() && $this->provider->isUsingProxy()) {
             $proxy = $this->getProxy();
             if ($proxy) {
                 $client->setDefaultOption('proxy', [
                     'http' => $proxy->url,
                     'https' => $proxy->url
                 ]);
                 if ($proxy->reqAuth) {
                     $client->setDefaultOption('headers', [
                         'Proxy-Authorization' => "Basic {$proxy->usrpwd}"
                     ]);
                 }
             }
         }

         return $client;
     }

    /**
     * Returns auth cookies
     *
     * @return string
     */
    public function getAuthCookies()
    {
        if ($this->authCookies === null) {
            $client = $this->getHttpClient();

            if (!$this->provider->auth_url || ($credential = $this->provider->getCredential()) === null) {
                throw new Exception('Invalid auth URL or no credentials found.');
            }

            //Trigger credential used event
            $credUsedEvent = new \service\components\events\CredentialUsedEvent();
            $credUsedEvent->content_provider_id = $this->provider->id;
            $credUsedEvent->content_provider_name = $this->provider->name;
            $credUsedEvent->credential_id = $credential->id;
            $credUsedEvent->user_id = (\Yii::$app->user->identity != null) ? \Yii::$app->user->identity->id : null;
            $this->trigger(self::EVENT_USE_CREDENTIALS, $credUsedEvent);

            $req = $client->createRequest('POST', $this->provider->auth_url, ['verify' => false, 'allow_redirects' => false]);
            $req->setHeader('User-Agent', $this->getUserAgent());
            $reqBody = $req->getBody();
            $reqBody->setField('op', 'login');
            $reqBody->setField('login', $credential->getDecryptedUser());
            $reqBody->setField('password', $credential->getDecryptedPass());

            $resp = $client->send($req);

            $cookies = array();
            foreach ($resp->getHeaderAsArray('Set-Cookie') as $cookie) {
                $cookies[] = SetCookie::fromString($cookie);
            }

            $values = [];
            $scheme = $req->getScheme();
            $host = $req->getHost();
            $path = $req->getPath();

            foreach ($cookies as $cookie) {
                if ($cookie->matchesPath($path) && $cookie->matchesDomain($host) && !$cookie->isExpired() && (!$cookie->getSecure() || $scheme == 'https')) {
                    $values[] = $cookie->getName() . '=' . CookieJar::getCookieValue($cookie->getValue());
                }
            }

            if ($values) {
                $this->authCookies = implode('; ', $values);
            } else {
                throw new Exception('Authorization failed.');
            }
        }

        return $this->authCookies;
    }

    /**
     * Returns direct download link
     *
     * @return string
     */
    public function getDownloadLink($url)
    {
        $client = $this->getHttpClient();

        /**
         * Since download link is generated by submitting form
         * We need to emulate that.
         */
        $req = $client->createRequest('GET', $url, ['verify' => false]);
        $req->setHeader('User-Agent', $this->getUserAgent());
        $req->setHeader('Cookie', $this->getAuthCookies());

        $resp = $client->send($req);

        $body = (string)$resp->getBody();

        $link = null;
        $fails = 0;

        $domDoc = new \DOMDocument();

        do {
            $req = $client->createRequest('POST', $url, ['verify' => false, 'allow_redirects' => false]);
            $req->setHeader('User-Agent', $this->getUserAgent());
            $req->setHeader('Cookie', $this->getAuthCookies());
            $reqBody = $req->getBody();

            //Parse DOM to get form fields...
            if (!$domDoc->hasChildNodes()) {
                @$domDoc->loadHtml($body);
            }

            $forms = $domDoc->getElementsByTagName('form');
            $form = null;
            for ($i = 0; $i < $forms->length; $i++) {
                //There are multiple forms with name F1, so we check also onsubmit attr
                if ('F1' == $forms->item($i)->getAttribute('name') && $forms->item($i)->getAttribute('onsubmit') != null) {
                    $form = $forms->item($i);
                    break;
                }
            }

            if ($form == null) {
                //No form found, something is wrong
                throw new Exception('Form for generating download URL not found on page.');
            }

            foreach ($form->getElementsByTagName('input') as $input) {
                if ($input->attributes->getNamedItem('name') != null && $input->attributes->getNamedItem('value') != null) {
                    $reqBody->setField($input->attributes->getNamedItem('name')->nodeValue, $input->attributes->getNamedItem('value')->nodeValue);
                }
            }

            if ($this->link->hasPassword()) {
                $reqBody->setField('password', $this->link->getPassword());
            }

            $resp = $client->send($req);

            $link = $resp->getHeader('Location');

            if (!preg_match('/https:\/\/d\d+\.usercdn\.com(:\d+)?\/.+/', $link)) {
                if (!empty($link)) {
                    $req = $client->createRequest('GET', $link, ['verify' => false]);
                    $req->setHeader('User-Agent', $this->getUserAgent());
                    $req->setHeader('Cookie', $this->getAuthCookies());
                    $resp = $client->send($req);
                }
                $body = (string)$resp->getBody();
                @$domDoc->loadHtml($body);
                $link = null;
            }

            $fails++;
        } while ($link == null && $fails <= 2);

        if ($link !== null) {
            return $link;
        } else {
            throw new Exception('Download URL not found on page.');
        }
    }

    /**
     * @inheritdoc
     */
    public function setUrl($url)
    {
        $this->url = $this->getDownloadLink($url);
    }

    /**
     * @inheritdoc
     */
    public function createStreamContext()
    {
        $context = new HttpContentStreamContext();
        $context->setOption('http', 'method', 'GET');
        $context->setOption('http', 'header', "Cookie: ".$this->getAuthCookies());
        $context->setOption('http', 'user_agent', $this->getUserAgent());
        //Set proxy
        $instance = \Yii::$app->service->instance;
        if ($instance->isProxyEnabled() && $this->provider->isUsingProxy()) {
            $proxy = $this->getProxy();
            if ($proxy) {
                $context->setOption('http', 'proxy', $proxy->url);
                if ($proxy->reqAuth) {
                    $context->addOption('http', 'header', "Proxy-Authorization: Basic {$proxy->usrpwd}");
                }
            }
        }

        return $context;
    }
}
