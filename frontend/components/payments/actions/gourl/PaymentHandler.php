<?php

namespace frontend\components\payments\actions\gourl;

use Yii;
use yii\base\Action;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use common\models\Order;
use frontend\components\payments\GourlPaymentGateway;

class PaymentHandler extends Action
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        Yii::$app->request->enableCsrfValidation = false;
    }

    /**
     * Renders Gourl payment form
     *
     * @return mixed
     */
    public function run($orderId)
    {
        $gourlGateway = new GourlPaymentGateway();

        //Check if order exists
        $user = Yii::$app->user->identity;

        $order = Order::find()
            ->where(['id' => $orderId])
            ->andWhere(['status' => Order::STATUS_PENDING])
            ->one();

        if ($order == null || $order->user->id != $user->id) {
            throw new NotFoundHttpException('Order not found.');
        }

        //Instantiate cryptobox
        include_once(__DIR__.'/../../includes/cryptoapi_php/cryptobox.class.php');

        if (!class_exists('Cryptobox')) {
            throw new HttpException(500, 'Failed to initialize cryptobox.');
        }

        $options = [
            'public_key' => $gourlGateway->getPublicKey(),
        	'private_key' => $gourlGateway->getPrivateKey(),
        	'webdev_key' => '',
        	'orderID' => $order->id,
        	'userID' => $user->id,
        	'userFormat' => 'COOKIE',
        	'amount' => 0,
        	'amountUSD' => $order->cost,
        	'period' => '24 HOUR',
        	'iframeID' => '',
        	'language' => 'EN'
        ];

        $cryptobox = new \Cryptobox ($options);

        //Check if payment is completed
        if ($cryptobox->is_paid()) {
            if ($cryptobox->is_confirmed()) {
                Yii::$app->session->setFlash('checkoutSuccessMessage', 'Your order is now being in processing state and you will be updated with email shortly when the campaign has been set.');

                $user = $order->user;

                if ($user->hasRole('reseller')) {
                    return $this->controller->redirect(Url::to(['@reseller_pay_vouchers']));
                } else {
                    return $this->controller->redirect(Url::to(['@profile_add_credits']));
                }
    		}
        }

        return Yii::$app->view->renderFile('@frontend/components/payments/views/gourl/paymentBox.php', [
                'cryptobox' => $cryptobox,
                'order' => $order
            ]
        );
    }
}
