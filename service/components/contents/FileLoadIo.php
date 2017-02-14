<?php

namespace service\components\contents;

use yii\base\Exception;
use \GuzzleHttp\Client;
use \GuzzleHttp\Cookie\SetCookie;
use \GuzzleHttp\Cookie\CookieJar;

/**
 * netload.in (fileload.io) content
 */
class FileLoadIo extends HttpContent
{
    private $proxy;
    private $userAgent;
    private $authToken;
    private $transferId;

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
     * Returns auth token
     *
     * @return string
     */
    public function getAuthToken()
    {
        if ($this->authToken === null) {
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

            $req = $client->createRequest('GET',
                $this->provider->auth_url.'/'.$credential->getDecryptedUser().'/'.md5($credential->getDecryptedPass()),
                ['verify' => false]
            );
            $req->setHeader('User-Agent', $this->getUserAgent());

            $resp = $client->send($req);
            $body = json_decode((string)$resp->getBody(), true);

            if (is_array($body)) {
                $body = reset($body);
            }

            if (isset($body['login_token'])) {
                $this->authToken = $body['login_token'];
            } else {
                throw new Exception('Failed to get auth token.');
            }
        }

        return $this->authToken;
    }

    /**
     * Returns transfer id from URL
     *
     * @param  string $url
     * @return string|null
     */
    public function getTransferIdFormUrl($url)
    {
        if ($this->transferId == null) {
            if (preg_match('/https:\/\/fileload\.io\/([A-Za-z0-9]+)(\/.+)?/', $url, $matches)) {
                if (isset($matches[1])) {
                    $this->transferId = $matches[1];
                }
            } else {
                throw new Exception('Failed to get transfer id.');
            }
        }

        return $this->transferId;
    }

    /**
     * Returns direct download link
     *
     * @return string
     */
    public function getDownloadLink($url)
    {
        $client = $this->getHttpClient();

        //Get download ticket using API
        $req = $client->createRequest('GET',
            "https://api.fileload.io/download/{$this->getAuthToken()}/{$this->getTransferIdFormUrl($url)}",
            ['verify' => false]
        );
        $req->setHeader('User-Agent', $this->getUserAgent());

        $resp = $client->send($req);

        $body = json_decode((string)$resp->getBody(), true);

        if (is_array($body)) {
            $body = reset($body);
        }

        if (isset($body['download_link'])) {
            return $body['download_link'];
        }

        throw new Exception('Download URL not found.');
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
