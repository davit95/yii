<?php

namespace service\components\contents;

use yii\base\Exception;
use \GuzzleHttp\Client;
use \GuzzleHttp\Cookie\SetCookie;
use \GuzzleHttp\Cookie\CookieJar;
use \GuzzleHttp\Event\ErrorEvent;

/**
 * rockfile.eu content
 */
class RockFileEu extends HttpContent
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

            $req = $client->createRequest('POST', $this->provider->auth_url, ['verify' => false, 'allow_redirects' => false, 'exceptions' => false]);
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

        $errors = array();

        $emitter = $client->getEmitter();
        $emitter->on('error', function (ErrorEvent $event) {
            //Get client
            $client = $event->getClient();
            //Get request
            $curReq = $event->getRequest();
            //Get response
            $curResp = $event->getResponse();
            $body = (string)$curResp->getBody();

            if (503 == $curResp->getStatusCode() && strpos($body, 'DDoS protection by CloudFlare') !== false) {
                //This is cloudflare DDoS protection. Try to bypass it...

                /**
                 * Solve JS challange...
                 *
                 * @see https://github.com/KyranRana/cloudflare-bypass
                 */
                $hostLen = mb_strlen($curReq->getHost(), 'utf8');
                $script  = substr($body, strpos($body, 'var t,r,a,f,') + mb_strlen('var t,r,a,f,', 'utf8'));
                $varname = trim(substr($script, 0, strpos($script, '=')));
                $script  = substr($script, strpos($script, $varname));
                //removing form submission event
                $script  = substr($script, 0, strpos($script, 'f.submit()'));
                //structuring javascript code for PHP conversion
                $script  = str_replace(array('t.length', 'a.value'), array($hostLen, '$answer'), $script);
                $script  = str_replace(array("\n", " "), "", $script);
                $script  = str_replace(array(";;", ";"), array(";", ";\n"), $script);
                //convert challenge code variables to PHP variables
                $script  = preg_replace("/[^answe]\b(a|f|t|r)\b(.innerhtml)?=.*?;/i", '', $script);
                $script  = preg_replace("/(\w+).(\w+)(\W+)=(\W+);/i", '$$1_$2$3=$4;', $script);
                $script  = preg_replace("/(parseInt)?\((\w+).(\w+),.*?\)/", 'intval($$2_$3)', $script);
                $script  = preg_replace("/(\w+)={\"(\w+)\":(\W+)};/i", '$$1_$2=$3;', $script);
                //convert javascript array matrix in equations to binary which PHP can understand
                $script  = str_replace(array("!![]", "!+[]"), 1, $script);
                $script  = str_replace(array("![]", "[]"), 0, $script);
                $script  = str_replace(array(")+", ").$hostLen"), array(").", ")+$hostLen"), $script);

                eval($script);

                $answer = (int)$answer;

                //Find challange form and submit it
                $domDoc = new \DOMDocument();
                @$domDoc->loadHtml($body);

                $form = $domDoc->getElementById('challenge-form');

                if ($form != null) {
                    $cfUrl = $curReq->getScheme().'://'.$curReq->getHost().$form->attributes->getNamedItem('action')->nodeValue;

                    $cfReq = $client->createRequest('GET', $cfUrl, ['verify' => false, 'allow_redirects' => false]);
                    //Don't forget to add current request cookies and set same user agent header
                    $cfReq->setHeader('Cookie', $curReq->getHeader('Cookie'));
                    $cfReq->setHeader('User-Agent', $curReq->getHeader('User-Agent'));
                    $cfReqBody = $cfReq->getQuery();

                    foreach ($form->getElementsByTagName('input') as $input) {
                        if ($input->attributes->getNamedItem('name') != null && $input->attributes->getNamedItem('value') != null) {
                            $cfReqBody->set($input->attributes->getNamedItem('name')->nodeValue, $input->attributes->getNamedItem('value')->nodeValue);
                        }
                    }

                    $cfReqBody->set('jschl_answer', $answer);

                    //Wait for 5 sec. Yep, really, no jokes...
                    sleep(5);

                    $cfResp = $client->send($cfReq);

                    $cfCookies = array();
                    foreach ($cfResp->getHeaderAsArray('Set-Cookie') as $cookie) {
                        $cfCookies[] = SetCookie::fromString($cookie);
                    }

                    $curCookies = explode('; ', $curReq->getHeader('Cookie'));

                    foreach ($cfCookies as $cookie) {
                        $curCookies[] = $cookie->getName() . '=' . CookieJar::getCookieValue($cookie->getValue());
                    }

                    $curReq->setHeader('Cookie', implode('; ', $curCookies));

                    $newResp = $client->send($curReq);

                    $event->intercept($newResp);
                }
            }
        });

        /**
         * Since download link is generated by submitting form
         * We need to emulate that.
         */
        $req = $client->createRequest('GET', $url, ['exceptions' => true]);
        $req->setHeader('User-Agent', $this->getUserAgent());
        $req->setHeader('Cookie', $this->getAuthCookies());

        $resp = $client->send($req);

        $body = (string)$resp->getBody();

        $links = null;
        $fails = 0;

        $domDoc = new \DOMDocument();

        do {
            $req = $client->createRequest('POST', $url,  ['exceptions' => true]);
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
                if ('F1' == $forms->item($i)->attributes->getNamedItem('name')->nodeValue) {
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

            $body = (string)$resp->getBody();

            @$domDoc->loadHtml($body);
            $forms = $domDoc->getElementsByTagName('form');
            $formExists = false;
            for ($i = 0; $i < $forms->length; $i++) {
                $formExists = ('F1' == $forms->item($i)->attributes->getNamedItem('name')->nodeValue);
                if ($formExists) {
                    break;
                }
            }
            if (!$formExists) {
                $links = $domDoc->getElementsByTagName('a');
            }

            $fails++;
        } while ($links == null && $fails <= 2);

        if ($links != null) {
            for ($i = 0; $i < $links->length; $i++) {
                $href = $links->item($i)->attributes->getNamedItem('href')->nodeValue;
                if (preg_match('/http:\/\/stn\d+\.rfservers\.eu(:\d+)?\/.+/', $href)) {
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
