<?php

namespace service\components\contents;

use \GuzzleHttp\Client;
use \GuzzleHttp\Cookie\SetCookie;
use \GuzzleHttp\Cookie\CookieJar;

/**
 * rarefile.net content
 */
//TODO: Fix this content class
class RareFileNet extends HttpContent
{
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
     * Returns auth cookies
     *
     * @return string
     */
    public function getAuthCookies()
    {
        if ($this->authCookies === null) {
            $client = new Client();

            $req = $client->createRequest('POST', 'http://www.rarefile.net/login.html', ['verify' => false, 'allow_redirects' => false,'cookies' => true]);
            $req->setHeader('User-Agent', $this->getUserAgent());
            $reqQuery = $req->getBody();
            $reqQuery->setField('op', 'login');
            $reqQuery->setField('login', 'Nlfooter83');
            $reqQuery->setField('password', 'jk3D*%KWtJbedcA');
            $resp = $client->send($req);

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
            }

        }

        return $this->authCookies;
    }

    /**
     * @inheritdoc
     */
    public function createStreamContext()
    {
        $context = new HttpContentStreamContext();
        $context->setOption('http', 'method', 'GET');
        $context->setOption('http', 'header', "Cookie: ".$this->getAuthCookies()."\r\n");
        $context->setOption('http', 'user_agent', $this->getUserAgent());
        return $context;
    }
}
