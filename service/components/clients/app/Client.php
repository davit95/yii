<?php

namespace service\components\clients\app;

use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;

/**
 * Class is used to interact with web app
 */
class Client extends Component
{
    private $baseUrl;
    private $options;

    /**
     * Constructs client object
     *
     * [[options]] is array of options. Avaliable options are:
     * - format defines desired response format (JSON|XML). JSON is default.
     * - auth is array of auth data. Format is :
     * [
     *     'type' => 'basic',
     *     'username' => 'user',
     *     'password' => 'pass'
     * ]
     * or
     * [
     *     'type' => 'bearer',
     *     'accessToken' => 'user's access token',
     * ]
     *
     * @param string $baseUrl base API URL
     * @param array $options  options passed to request
     */
    public function __construct ($baseUrl, $options = [])
    {
        $this->baseUrl = $baseUrl;
        $this->setOptions($options);

        $this->init();
    }

    /**
     * Sets request options
     *
     * @param void
     */
    private function setOptions($options)
    {
        if (is_array($options)) {
            $this->options = $options;
        } else {
            throw new InvalidParamException('Invalid options.');
        }
    }

    /**
     * Returns option value
     *
     * @return mixed
     */
    private function getOption($option, $default = null)
    {
        return (isset($this->options[$option])) ? $this->options[$option] : $default;
    }

    /**
     * Sends authentication request to auth server
     *
     * @param  string $username
     * @param  string $password
     * @return service\components\clients\app\Response
     */
    public function authenticate($username, $password = null)
    {
        if ($password != null) {
            //Username and password provided
            $params = ['username' => $username, 'password' => $password];
        } else {
            //No password given treat username as authKey
            $params = ['username' => $username];
        }
        $request = new Request('POST',
            $this->baseUrl.'/user/auth/',
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Sends ticket validation request
     *
     * @param  string $ticket
     * @return service\components\clients\app\Response
     */
    public function validateTicket($ticket)
    {
        $params = ['ticket' => $ticket];
        $request = new Request('GET',
            $this->baseUrl.'/ticket/validate/',
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Renews ticket
     *
     * @return service\components\clients\app\Response
     */
    public function renewTicket()
    {
        $params = [];
        $request = new Request('GET',
            $this->baseUrl.'/ticket/renew/',
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Adds new record to download journal
     *
     * @param  string $svc      service uid
     * @param  integer $uid     user id
     * @param  string $provider provider name
     * @param  integer $bytes   bytes sent`
     * @return service\components\clients\app\Response
     */
    public function pushDownloadJournal($svc, $uid, $provider, $bytes)
    {
        $params = [
            'service_uid' => $svc,
            'user_id' => $uid,
            'provider' => $provider,
            'bytes_sent' => $bytes
        ];
        $request = new Request('POST',
            $this->baseUrl.'/download-journal/push/',
            $params,
            $this->options
        );
        return $request->send();
    }
}
