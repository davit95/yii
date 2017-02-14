<?php

namespace frontend\components\payments\actions\payssion;

use Yii;
use yii\base\Action;
use yii\helpers\Url;

class ReturnUrlHandler extends Action
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        //Disable csrf validation
        Yii::$app->request->enableCsrfValidation = false;
    }

    /**
     * Handles return url request from payssion
     *
     * @return mixed
     */
    public function run()
    {
        $data = Yii::$app->request->get();

        if (isset($data['state']) && ($data['state'] == 'completed' || $data['state'] == 'pending')) {
            Yii::$app->session->setFlash('checkoutSuccessMessage', 'Your order is now being in processing state and you will be updated with email shortly when the campaign has been set.');
        } else {
            Yii::$app->session->setFlash('checkoutErrorMessage', 'Seems we have problems while checkout. Please contuct us.');
        }

        $this->controller->redirect(Url::to(['@profile_add_credits']));
    }
}
