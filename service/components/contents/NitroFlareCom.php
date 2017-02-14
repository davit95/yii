<?php

namespace service\components\contents;

use yii\base\Exception;
use \GuzzleHttp\Client;
use \GuzzleHttp\Cookie\SetCookie;
use \GuzzleHttp\Cookie\CookieJar;

/**
 * nitroflare.com content
 */
class NitroFlareCom extends HttpContent
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
            $resp = $client->send($req);
            $body = (string)$resp->getBody();

            $domDoc = new \DOMDocument();
            @$domDoc->loadHtml($body);

            $form = $domDoc->getElementById('login');
            if ($form === null) {
                throw new Exception('Login form not found.');
            }

            $token = null;
            foreach ($form->getElementsByTagName('input') as $input) {
                if ($input->getAttribute('name') == 'token') {
                    $token = $input->getAttribute('value');
                }
            }

            $sessCookie = null;
            $cookies = $resp->getHeaderAsArray('Set-Cookie');
            foreach ($cookies as $cookie) {
                if (preg_match('/^PHPSESSID/', $cookie)) {
                    $sessCookie = SetCookie::fromString($cookie);
                }
            }

            if ($sessCookie === null) {
                //No session cookies
                throw new Exception('Failed to get session cookie.');
            }

            $req = $client->createRequest('POST', $this->provider->auth_url, [
                'verify' => false,
                'allow_redirects' => false,
                'cookies' => ['PHPSESSID' => $sessCookie->getValue()]
            ]);
            $req->setHeader('User-Agent', $this->getUserAgent());
            $reqBody = $req->getBody();
            $reqBody->setField('email', $credential->getDecryptedUser());
            $reqBody->setField('password', $credential->getDecryptedPass());
            $reqBody->setField('token', $token);
            $reqBody->setField('login', '');

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
            //Add session cookie
            $values[] = $sessCookie->getName() . '=' . CookieJar::getCookieValue($sessCookie->getValue());

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

        $req = $client->createRequest('GET', $url, ['verify' => false]);
        $req->setHeader('User-Agent', $this->getUserAgent());
        $req->setHeader('Cookie', $this->getAuthCookies());

        $resp = $client->send($req);

        $body = (string)$resp->getBody();

        $domDoc = new \DOMDocument();
        @$domDoc->loadHtml($body);

        foreach ($domDoc->getElementsByTagName('a') as $link) {
            $href = $link->getAttribute('href');
            if (preg_match('/http:\/\/s\d+\.nitroflare\.com\/.+/', $href)) {
                return $href;
            }
        }

        throw new Exception('Download URL not found on page.');
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
