<?php

namespace frontend\components\payments;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use common\models\Order;

/**
 * Gourl payment gateway
 *
 * Gourl payment gateway implementation
 */
class GourlPaymentGateway extends Component implements PaymentGatewayInterface
{
    private $publicKey;
    private $privateKey;
    private $submitUrl = '/order/gourl-payment';


    /**
     * @inheritdoc
     */
    public function init()
    {
        $config = Yii::$app->config;

        $this->publicKey = $config->get('Gourl.PublicKey');
        $this->privateKey = $config->get('Gourl.PrivateKey');

        if ($this->publicKey == null || $this->privateKey == null) {
            throw new InvalidConfigException();
        }
    }

    /**
     * Returns public key
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Returns private key
     *
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @inheritdoc
     */
    public static function actions()
    {
        return [
            'gourl-payment' => 'frontend\components\payments\actions\gourl\PaymentHandler',
        ];
    }

    /**
     * @inheritdoc
     */
    public function renderOrderForm(Order $order, $paymentMethod)
    {
        return Yii::$app->view->renderFile('@frontend/components/payments/views/gourl/orderForm.php', [
                'submitUrl' => $this->submitUrl,
                'order' => $order
            ]
        );
    }
}
