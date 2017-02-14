<?php

namespace frontend\components\payments;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use common\models\Order;
use common\models\UserPlan;
use common\models\Transaction;

/**
 * Paysion payment gateway
 *
 * Payssion payment gateway implementation
 */
class PayssionPaymentGateway extends Component implements PaymentGatewayInterface
{
    private $apiKey;
    private $apiSecret;
    private $submitUrl;
    private $returnUrl;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $config = Yii::$app->config;

        $this->apiKey = $config->get('Payssion.ApiKey');
        $this->apiSecret = $config->get('Payssion.ApiSecret');
        $this->submitUrl = $config->get('Payssion.SubmitUrl');
        $this->returnUrl = $config->get('Payssion.ReturnUrl');

        if ($this->apiKey == null || $this->apiSecret == null) {
            throw new InvalidConfigException();
        }
    }

    /**
     * @inheritdoc
     */
    public static function actions()
    {
        return [
            'payssion-handle-return-url' => 'frontend\components\payments\actions\payssion\ReturnUrlHandler',
            'payssion-handle-notification' => 'frontend\components\payments\actions\payssion\NotificationHandler'
        ];
    }

    /**
     * @inheritdoc
     */
    public function renderOrderForm(Order $order, $paymentMethod)
    {
        return Yii::$app->view->renderFile('@frontend/components/payments/views/payssion/orderForm.php', [
                'apiKey' => $this->apiKey,
                'apiSecret' => $this->apiSecret,
                'submitUrl' => $this->submitUrl,
                'returnUrl' => $this->returnUrl,
                'pmId' => $paymentMethod,
                'order' => $order
            ]
        );
    }

    /**
     * Validates response from payssion by comparing signatures
     *
     * @param  array  $response payssion request data
     * @return boolean
     */
    public function isValidResponse($response)
    {
        if (isset($response['pm_id']) &&
            isset($response['amount']) &&
            isset($response['currency']) &&
            isset($response['order_id']) &&
            isset($response['state']) &&
            isset($response['notify_sig'])) {

            $arr = [
                $this->apiKey,
                $response['pm_id'],
                $response['amount'],
                $response['currency'],
                $response['order_id'],
                $response['state'],
                $this->apiSecret
            ];

            $sign = md5(implode('|', $arr));
            return ($sign == $response['notify_sig']);
        }

        return false;
    }
}
