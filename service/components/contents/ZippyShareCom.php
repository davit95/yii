<?php

namespace service\components\contents;

use yii\base\Exception;
use \GuzzleHttp\Client;
use \GuzzleHttp\Cookie\SetCookie;
use \GuzzleHttp\Cookie\CookieJar;

/**
 * zippyshare.com content
 */
class ZippyShareCom extends HttpContent
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
            $reqBody = $req->getBody();

            $reqBody->setField('login', $credential->getDecryptedUser());
            $reqBody->setField('pass', $credential->getDecryptedPass());

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

        $req = $client->createRequest('GET', $url);
        $req->setHeader('User-Agent', $this->getUserAgent());
        $req->setHeader('Cookie', $this->getAuthCookies());

        $resp = $client->send($req);

        $body = (string)$resp->getBody();

        $seg = parse_url($url);
        $href = "{$seg['scheme']}://{$seg['host']}";

        preg_match_all('/<script[^<>]*>([^<>]*)<\/script>/', $body, $res);

        $script = '';
        /*
        foreach ($res[1] as $one) {
            if (strpos($one, 'var b = 1234567') !== false) {
                $script = $one;
                break;
            }
        }

        preg_match('/a\s?=\s?([\d]+)/', $script, $a);
        preg_match('/b\s?=\s?([\d]+)/', $script, $b);

        $a = isset($a[1]) ? (int)$a[1] : 0;
        $b = isset($b[1]) ? (int)$b[1] : 0;
        $res = (($a + 3) * 3) % $b + 3;

        preg_match_all('/"(.+)"/sU', $script, $linkParts);

        $p1 = isset($linkParts[0][0]) ? trim($linkParts[0][0], ' \t\n\r\0\x0B"') : '';
        $p2 = isset($linkParts[0][1]) ? trim($linkParts[0][1], ' \t\n\r\0\x0B"') : '';
        */

        /*
        $a = 1;
        $b = $a + 1;
        $c = $b + 1;
        $d = 2 * 2;

        foreach ($res[1] as $one) {
            if (strpos($one, 'var a = function() {return 1};') !== false) {
                $script = $one;
                break;
            }
        }

        preg_match('/href\s?=\s?".+"\+\((.*)\)\+".+";/', $script, $expr);

        $expr = isset($expr[1]) ? $expr[1] : '';

        $expr = str_ireplace('a()', $a, $expr);
        $expr = str_ireplace('b()', $b, $expr);
        $expr = str_ireplace('c()', $c, $expr);
        $expr = str_ireplace('d', $d, $expr);

        $res = eval('return '.$expr.';');

        preg_match('/href\s?=\s?"(.+)"\+\(.*\)\+"(.+)";/', $script, $linkParts);

        $p1 = isset($linkParts[1]) ? trim($linkParts[1], ' \t\n\r\0\x0B"') : '';
        $p2 = isset($linkParts[2]) ? trim($linkParts[2], ' \t\n\r\0\x0B"') : '';

        $href = "{$seg['scheme']}://{$seg['host']}{$p1}{$res}{$p2}";
        */

        foreach ($res[1] as $one) {
            if (strpos($one, 'dlbutton') !== false) {
                $script = $one;
                break;
            }
        }

        if (class_exists('\V8Js')) {
            $v8 = new \V8Js();

            //Searches where download buttom href is set. That is place where we should call 'return'
            $returnRule = 'document\.[a-z][a-zA-Z0-9_]+\(\'dlbutton\'\).href\s?=';

            //Replaces all DOM objects by plain variables
            $replaceRules = [
                [
                    'pattern' => 'document\.[a-z][a-zA-Z0-9_]+\([\'a-zA-Z0-9-]+\)',
                    'var' => 'v',
                    'initVal' => '{}'
                ]
            ];

            $varMap = [];

            $script = preg_replace("/{$returnRule}/", 'return', $script);

            $varIndex = 0;
            foreach ($replaceRules as $replaceRule) {
                if (preg_match_all("/{$replaceRule['pattern']}/", $script, $matches)) {
                    foreach ($matches[0] as $match) {
                        if (!isset($varMap[$match])) {
                            $varMap[$match] = [
                                'var' => $replaceRule['var'].$varIndex++,
                                'initVal' => $replaceRule['initVal']
                            ];
                        }
                    }
                }
            }

            $varInit = '';
            foreach ($varMap as $orig => $repl) {
                $script = str_replace($orig, $repl['var'], $script);
                $varInit .= "var {$repl['var']}={$repl['initVal']};";
            }

            $script = str_replace(["\r\n","\n"], '', $script);
            $script = "(function () {{$varInit}{$script}})();";

            try {
                $res = $v8->executeString($script, 'zippyshare.js');
            } catch (\V8JsException $e) {
                \Yii::error('Failed to solve zippyshare JS' . $e->getMessage());
            }

            $href = "{$seg['scheme']}://{$seg['host']}{$res}";
        } else {
            /*$a = 0;
            if (preg_match('/var a\s?=\s?(\d+)\s?;/', $script, $matches)) {
                $a = (int)$matches[1];
            }
            $b = 3;

            $res = (int)pow($a, 3) + $b;

            preg_match('/dlbutton.+\.href\s?=\s?"(.+)"\+\(.*\)\+"(.+)";/', $script, $linkParts);

            $p1 = isset($linkParts[1]) ? trim($linkParts[1], ' \t\n\r\0\x0B"') : '';
            $p2 = isset($linkParts[2]) ? trim($linkParts[2], ' \t\n\r\0\x0B"') : '';

            $href = "{$seg['scheme']}://{$seg['host']}{$p1}{$res}{$p2}";*/

            $a = 0;
            if (preg_match('/var a\s?=\s?(\d+)\s?;/', $script, $matches)) {
                $a = (int)$matches[1];
            }
            $b = 0;
            if (preg_match('/var b\s?=\s?(\d+)\s?;/', $script, $matches)) {
                $b = (int)$matches[1];
            }

            $res = floor($a / 3) + $a % $b;

            preg_match('/dlbutton.+\.href\s?=\s?"(.+)"\+\(.*\)\+"(.+)";/', $script, $linkParts);

            $p1 = isset($linkParts[1]) ? trim($linkParts[1], ' \t\n\r\0\x0B"') : '';
            $p2 = isset($linkParts[2]) ? trim($linkParts[2], ' \t\n\r\0\x0B"') : '';

            $href = "{$seg['scheme']}://{$seg['host']}{$p1}{$res}{$p2}";
        }

        return $href;
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
