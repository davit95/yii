<?php

namespace service\components\contents;

use yii\base\Exception;
use \GuzzleHttp\Client;
use \GuzzleHttp\Cookie\SetCookie;
use \GuzzleHttp\Cookie\CookieJar;

/**
 * ulozto.net content
 */
class UlozToNet extends HttpContent
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

            $arr = $this->getFirstTokenAndCookie();
            $token = $arr['token'];
            $cookie = $arr['cookie'];

            $req = $client->createRequest('POST', $this->provider->auth_url, ['verify' => false, 'allow_redirects' => false]);
            $req->setHeader('User-Agent', $this->getUserAgent());
            $req->setHeader('Cookie', $cookie);

            $reqBody = $req->getBody();
            $reqBody->setField('username', $credential->getDecryptedUser());
            $reqBody->setField('password', $credential->getDecryptedPass());
            $reqBody->setField('login', 'Submit');
            $reqBody->setField('_do', 'loginForm-submit');
            $reqBody->setField('_token_', $token);

            $resp = $client->send($req);

            $this->authCookies = $this->getCookieByResponse($resp, $req->getScheme(), $req->getHost(), $req->getPath());
        }

        return $this->authCookies;
    }

    /**
     * Returns cookies string from guzzle response
     *
     * @param  Response $resp
     * @param  string $scheme
     * @param  string $host
     * @param  string $path
     * @return string
     */
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

    /**
     * Returns token and cookie which is required to login
     *
     * @return arrar
     */
    public function getFirstTokenAndCookie()
    {
        $client = $this->getHttpClient();

        $req = $client->createRequest('GET', $this->provider->auth_url, ['verify' => false, 'allow_redirects' => false]);
        $req->setHeader('User-Agent', $this->getUserAgent());

        $resp = $client->send($req);

        $body = (string)$resp->getBody();

        $domDoc = new \DOMDocument();
        @$domDoc->loadHtml($body);

        $input = $domDoc->getElementById('frm-loginForm-_token_');
        $token = $input->getAttribute('value');

        $cookie = $this->getCookieByResponse($resp, $req->getScheme(), $req->getHost(), $req->getPath());

        return [
            'token' => $token,
            'cookie' => $cookie,
        ];
    }

    /**
     * Returns direct download link
     *
     * @return string
     */
    public function getDownloadLink($url)
    {
        $client = $this->getHttpClient();

        $req = $client->createRequest('GET', $url, ['verify' => false, 'allow_redirects' => true]);
        $req->setHeader('User-Agent', $this->getUserAgent());
        $req->setHeader('Cookie', $this->getAuthCookies());

        $resp = $client->send($req);

        $body = (string)$resp->getBody();

        //Parse DOM to get form fields...
        $domDoc = new \DOMDocument();
        @$domDoc->loadHtml($body);

        $a = $domDoc->getElementById('quickDownloadButton');
        if ($a === null) {
            throw new Exception('Download URL not found on page.');
        }
        $href = $a->getAttribute('href');

        return 'http://ulozto.net' . $href;
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
