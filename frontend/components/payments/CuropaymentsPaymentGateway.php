<?php

namespace frontend\components\payments;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use common\models\Order;
use common\models\UserPlan;
use common\models\Transaction;

/**
 * Curopayments payment gateway
 *
 * Curopayments payment gateway implementation
 */
class CuropaymentsPaymentGateway extends Component implements PaymentGatewayInterface
{
    private $siteId;
    private $hashKey;
    private $submitUrl;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $config = Yii::$app->config;

        $this->siteId = $config->get('Curopayments.SiteId');
        $this->hashKey = $config->get('Curopayments.HashKey');
        $this->submitUrl = $config->get('Curopayments.SubmitUrl');

        if ($this->siteId == null || $this->hashKey == null) {
            throw new InvalidConfigException();
        }
    }

    /**
     * @inheritdoc
     */
    public static function actions()
    {
        return [
            'curopayments-handle-return-url' => 'frontend\components\payments\actions\curopayments\ReturnUrlHandler',
            'curopayments-handle-notification' => 'frontend\components\payments\actions\curopayments\CallbackUrlHandler'
        ];
    }

    /**
     * Returns order hash
     *
     * @param  Order  $order
     * @return string
     */
    private function getOrderHash(Order $order)
    {
        return md5($this->siteId.($order->cost * 100).$order->id.$this->hashKey);
    }

    /**
     * Checks is response from curopayments is valid
     *
     * @param  array  $response
     * @return boolean
     */
    public function isValidResponse($response)
    {
        if (isset($response['transaction']) &&
            isset($response['code']) &&
            isset($response['reference']) &&
            isset($response['hash']) &&
            isset($response['currency']) &&
            isset($response['amount'])) {

            $hash = md5($response['transaction'].$response['currency'].$response['amount'].$response['reference'].$response['code'].$this->hashKey);
            return ($hash == $response['hash']);
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function renderOrderForm(Order $order, $paymentMethod)
    {
        return Yii::$app->view->renderFile('@frontend/components/payments/views/curopayments/orderForm.php', [
            'siteId' => $this->siteId,
            'hash' => $this->getOrderHash($order),
            'submitUrl' => $this->submitUrl,
            'paymentMethod' => $paymentMethod,
            'order' => $order
        ]);
    }

}
