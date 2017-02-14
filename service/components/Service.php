<?php

namespace service\components;

use Yii;
use yii\base\Exception;
use yii\base\Component;
use service\models\Instance;
use service\components\clients\app\Client;

class Service extends Component
{
    private $instance;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();

        $uid = $this->getParam('serviceUid');
        $instance = Instance::find()->where(['uid' => $uid])->one();

        if ($instance == null) {
            throw new Exception('Service instance with given uid not found.');
        }

        $this->setInstance($instance);
    }

    /**
     * Returns service param from param file
     *
     * @param  string $param
     * @return string
     */
    public function getParam($param)
    {
        return isset(Yii::$app->params[$param]) ? Yii::$app->params[$param] : null;
    }

    /**
     * Sets service instance
     *
     * @param service\models\Instance $model
     */
    private function setInstance(Instance $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Returns service instance model
     *
     * @return service\models\Instance $model
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * Returns web app client
     *
     * @return service\components\clients\app\Client
     */
    public function getAppClient($options = [])
    {
        return new Client($this->instance->app_api_url, $options);
    }

    /**
     * Returns number of current connections
     *
     * @return integer
     */
    public function getConnectionsNumber()
    {
        return (int)exec('netstat -ntu | grep :80 | grep -v LISTEN | awk \'{print $5}\' | cut -d: -f1 | grep -v 127.0.0.1 | wc -l');
    }
}
