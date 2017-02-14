<?php

namespace service\components\contents;

use yii\base\Exception;
use \GuzzleHttp\Client;
use \GuzzleHttp\Cookie\SetCookie;
use \GuzzleHttp\Cookie\CookieJar;

/**
 * turbobit.net content
 */
class TurboBitNet extends HttpContent
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

            $req = $client->createRequest('POST', $this->provider->auth_url, ['allow_redirects' => false]);
            $req->setHeader('User-Agent', $this->getUserAgent());
            $req->setHeader('Cookie', $this->getFirstCookie());
            $reqBody = $req->getBody();
            $reqBody->setField('user[login]', $credential->getDecryptedUser());
            $reqBody->setField('user[pass]', $credential->getDecryptedPass());
            $reqBody->setField('user[submit]', 'Sign in');

            $resp = $client->send($req);

            $this->authCookies = $this->getCookieByResponse($resp, $req->getScheme(), $req->getHost(), $req->getPath());
        }

        return $this->authCookies;
    }

    public function getCookieByResponse($resp, $scheme, $host, $path)
    {
        $stringOfCookie = null;

        $cookies = array();
        foreach ($resp->getHeaderAsArray('Set-Cookie') as $cookie) {
            $cookies[] = SetCookie::fromString($cookie);
        }

        $values = [];
        foreach ($cookies as $cookie) {
            if ($cookie->matchesPath($path) && $cookie->matchesDomain($host) && !$cookie->isExpired() && (!$cookie->getSecure() || $scheme == 'https')) {
                $values[] = $cookie->getName() . '=' . CookieJar::getCookieValue($cookie->getValue());
            }
        }

        if ($values) {
            $stringOfCookie = implode('; ', $values);
        }

        return $stringOfCookie;
    }

    public function getFirstCookie()
    {
        $client = $this->getHttpClient();

        $req = $client->createRequest('GET', 'http://turbobit.net/', ['allow_redirects' => false]);
        $req->setHeader('User-Agent', $this->getUserAgent());

        $resp = $client->send($req);

        $cookie = $this->getCookieByResponse($resp, $req->getScheme(), $req->getHost(), $req->getPath());

        return $cookie;
    }

    /**
     * Returns direct download link
     *
     * @return string
     */
    public function getDownloadLink($url)
    {
        $client = $this->getHttpClient();

        $req = $client->createRequest('GET', $url, ['allow_redirects' => false]);
        $req->setHeader('User-Agent', $this->getUserAgent());
        $req->setHeader('Cookie', $this->getAuthCookies());

        $resp = $client->send($req);

        $body = (string)$resp->getBody();

        //Parse DOM to get form fields...
        $domDoc = new \DOMDocument();
        @$domDoc->loadHtml($body);
        $div = $domDoc->getElementById('premium-file-links');
        if ($div != null) {
            $a = $div->getElementsByTagName('a');
            if ($a->length > 0) {
                $href = $a->item(0)->getAttribute('href');
                if ($href != null) {
                    return $href;
                }
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
