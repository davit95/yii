<?php

namespace service\components\contents;

use yii\base\Exception;
use \GuzzleHttp\Client;
use \GuzzleHttp\Cookie\SetCookie;
use \GuzzleHttp\Cookie\CookieJar;

/**
 * solidfiles.com content
 */
class SolidFilesCom extends HttpContent
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

            $req = $client->createRequest('GET', $this->provider->auth_url, ['verify' => false]);
            $req->setHeader('User-Agent', $this->getUserAgent());

            $resp = $client->send($req);

            $body = (string)$resp->getBody();

            //Parse DOM to get form fields...
            $domDoc = new \DOMDocument();
            @$domDoc->loadHtml($body);

            $forms = $domDoc->getElementsByTagName('form');

            if ($forms->length == 0) {
                throw new Exception('Form for generating download URL not found on page.');
            }

            $form = $forms[0];

            $token = '';
            foreach ($form->getElementsByTagName('input') as $input) {
                if ($input->getAttribute('name') == 'csrfmiddlewaretoken') {
                    $token = $input->getAttribute('value');
                }
            }

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
                $cookies = implode('; ', $values);
            }

            $req = $client->createRequest('POST', $this->provider->auth_url, ['verify' => false, 'allow_redirects' => false]);
            $req->setHeader('User-Agent', $this->getUserAgent());
            $req->setHeader('Referer', $this->provider->auth_url);
            $req->setHeader('Cookie', $cookies);

            $reqBody = $req->getBody();
            $reqBody->setField('login', $credential->getDecryptedUser());
            $reqBody->setField('password', $credential->getDecryptedPass());
            $reqBody->setField('csrfmiddlewaretoken', $token);

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

        $url = preg_replace('/^https/', 'http', $url);

        $req = $client->createRequest('GET', $url, ['verify' => false, 'allow_redirects' => false]);
        $req->setHeader('User-Agent', $this->getUserAgent());
        $req->setHeader('Cookie', $this->getAuthCookies());

        $resp = $client->send($req);

        $link = $resp->getHeader('Location');

        if ($link) {
            $req = $client->createRequest('GET', $link, ['verify' => false, 'allow_redirects' => false]);
            $req->setHeader('User-Agent', $this->getUserAgent());
            $req->setHeader('Cookie', $this->getAuthCookies());

            $link = $resp->getHeader('Location');

            if (!preg_match('/https:\/\/s\d+\-premium\.solidfilesusercontent\.com\/.+/', $link)) {
                $link = null;
            }
        } else {
            $body = (string)$resp->getBody();

            $domDoc = new \DOMDocument();
            @$domDoc->loadHtml($body);

            foreach ($domDoc->getElementsByTagName('a') as $link) {
                $attr = $link->attributes->getNamedItem('href');
                if ($attr != null) {
                    $href = $attr->nodeValue;
                    if (preg_match('/https:\/\/s\d+\-premium\.solidfilesusercontent\.com\/.+/', $href)) {
                        $link = $href;
                        break;
                    }
                }
            }

            foreach ($domDoc->getElementsByTagName('img') as $img) {
                $attr = $img->attributes->getNamedItem('src');
                if ($attr != null) {
                    $href = $attr->nodeValue;
                    if (preg_match('/https:\/\/i\.solidfiles\.com\/.+/', $href)) {
                        $link = $href;
                        break;
                    }
                }
            }
        }

        if ($link) {
            return $link;
        } else {
            throw new Exception('Download URL not found.');
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
