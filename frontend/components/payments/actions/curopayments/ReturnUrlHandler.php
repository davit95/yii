<?php

namespace frontend\components\payments\actions\curopayments;

use Yii;
use yii\base\Action;
use yii\helpers\Url;
use common\models\Order;

class ReturnUrlHandler extends Action
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        //Discable csrf validation
        Yii::$app->request->enableCsrfValidation = false;
    }

    /**
     * Handles callback url request from curopayments
     *
     * @return mixed
     */
    public function run()
    {
        $data = Yii::$app->request->get();

        if (isset($data['status']) && ($data['status'] == 'success' || $data['status'] == 'pending')) {
            Yii::$app->session->setFlash('checkoutSuccessMessage', 'Your order is now being in processing state and you will be updated with email shortly when the campaign has been set.');
        } else {
            Yii::$app->session->setFlash('checkoutErrorMessage', 'Seems we have problems while checkout. Please contuct us.');
        }

        if (isset($data['reference'])) {
            $order = Order::findOne($data['reference']);
            if ($order != null) {
                $user = $order->user;
            }
        }

        if (isset($user) && $user->hasRole('reseller')) {
            return $this->controller->redirect(Url::to(['@reseller_pay_vouchers']));
        } else {
            return $this->controller->redirect(Url::to(['@profile_add_credits']));
        }
    }
}
