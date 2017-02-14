<?php

namespace common\components\clients\service;

use Yii;
use yii\base\Component;

class Request extends Component
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    private $method;
    private $url;
    private $auth;
    private $params;
    private $options;
    private $httpClient;

    /**
     * Initializes request object
     *
     * @param string $method
     * @param string $url
     * @param string $params
     * @param string $options
     * @return void
     */
    public function __construct ($method, $url, $params = [], $options = [])
    {
        $this->url = $url;
        $this->setMethod($method);
        $this->setParams($params);
        $this->setOptions($options);

        $this->httpClient = new \GuzzleHttp\Client();

        $this->init();
    }

    /**
     * Sets request method
     *
     * @param void
     */
    public function setMethod($method)
    {
        if (in_array($method, [self::METHOD_GET, self::METHOD_POST, self::METHOD_PUT, self::METHOD_DELETE])) {
            $this->method = $method;
        } else {
            throw new InvalidParamException('Invalid request method.');
        }
    }

    /**
     * Sets request params
     *
     * @return void
     */
    private function setParams($params)
    {
        if (is_array($params)) {
            $this->params = $params;
        } else {
            throw new InvalidParamException('Invalid request parameters.');
        }
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
            throw new InvalidParamException('Invalid request options.');
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
     * Sends request and returns response instance
     *
     * @return Response
     */
    public function send()
    {
        //Create request
        $request = $this->httpClient->createRequest($this->method, $this->url, ['exceptions' => false]);

        //Set response format
        $query = $request->getQuery();
        $query->set('_format', $this->getOption('format', Response::FORMAT_JSON));

        //Set auth header
        $auth = $this->getOption('auth', null);
        if ($auth !== null) {
            $authType = isset($auth['type']) ? strtolower($auth['type']) : null;
            if ($authType == 'basic') {
                $usrpwd = base64_encode($auth['username'].':'.$auth['password']);
                $request->addHeader('Authorization', "Basic $usrpwd");
            } else if ($authType == 'bearer') {
                $request->addHeader('Authorization', "Bearer {$auth['accessToken']}");
            }
        }

        //Add params to request
        switch ($this->method) {
            case self::METHOD_GET:
                $query = $request->getQuery();
                foreach ($this->params as $param=>$value) {
                    $query->set($param, $value);
                }
                break;
            case self::METHOD_POST:
            case self::METHOD_PUT:
            case self::METHOD_DELETE:
                $body = $request->getBody();
                foreach ($this->params as $param=>$value) {
                    $body->setField($param, $value);
                }
                break;
        }

        //Send request
        $response = $this->httpClient->send($request);

        //Construct new Response instance from http client response and return it
        return new Response($response, $this->getOption('format', Response::FORMAT_JSON));
    }

}
