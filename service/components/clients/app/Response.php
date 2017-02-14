<?php

namespace service\components\clients\app;

use Yii;
use yii\base\Component;
use yii\base\Exception;

class Response extends Component
{
    const FORMAT_XML = 'xml';
    const FORMAT_JSON = 'json';

    private $format;
    private $response;
    private $body;

    /**
     * Initializes response instance
     *
     * @param ResponseInterface $response
     * @param string            $format
     * @return void
     */
    public function __construct (\GuzzleHttp\Message\ResponseInterface $response, $format = self::FORMAT_JSON)
    {
        if (in_array($format, [self::FORMAT_XML, self::FORMAT_JSON])) {
            $this->format = $format;
        } else {
            throw new InvalidParamException('Invalid response format');
        }
        $this->response = $response;

        $this->init();
    }

    /**
     * Returns true if response was successfull
     *
     * @return boolean
     */
    public function isSuccess()
    {
        return (200 == $this->response->getStatusCode());
    }

    /**
     * Returns response body in given format
     *
     * @return mixed
     */
    public function getBody()
    {
        if ($this->body == null) {
            switch ($this->format) {
                case self::FORMAT_JSON:
                    $this->body = $this->response->json(['object' => true]);
                    break;
                case self::FORMAT_XML:
                    $this->body = $this->response->xml();
                    break;
                default:
                    $this->body = null;
            }
        }

        return $this->body;
    }

    /**
     * Returns message
     *
     * @return string|null
     */
    public function getMessage()
    {
        $body = $this->getBody();
        return (isset($body->message)) ? (string)$body->message : null;
    }

    /**
     * Returns errors
     *
     * @return mixed
     */
    public function getErrors()
    {
        $body = $this->getBody();
        return (isset($body->errors)) ? $body->errors : null;
    }
}
