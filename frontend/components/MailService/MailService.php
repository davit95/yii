<?php

namespace frontend\components\MailService;

use Yii;
use yii\base\Component;
use yii\base\InvalidParamException;
use common\models\ApiCredential;
use yii\di\Container;
use yii\web\UrlManager;

class MailService extends Component
{
    /**
     * Send Remainder Email
     * @param email
     * @return boolean
     */
    public function SendReminderEmail($user){
        try {
            $subject = 'Plan bytes Limit Reminder';

            Yii::$app->mailer->compose('reminder-html',[
                    'content' => $user->product,
                ])
            ->setFrom(\Yii::$app->params['supportEmail'])
            ->setTo($user->email)
            ->setSubject($subject)
            ->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Send Payment Success Transaction
     * @param email
     * @return boolean
     */
    public function sendSuccessEmail($order){
        try {
            $subject = 'Payment Success Transnaction';

            Yii::$app->mailer->compose('reminder-success-html',[
                'content' => $order,
                ])
            ->setFrom(\Yii::$app->params['supportEmail'])
            ->setTo($order['email'])
            ->setSubject($subject)
            ->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Send Payment Processing Transaction
     * @param email
     * @return boolean
     */
    public function sendProcessingEmail($order){
        try {
            $subject = 'Payment Processing Trasnaction';

            Yii::$app->mailer->compose('reminder-processing-html',[
                'content' => $order,
                ])
            ->setFrom(\Yii::$app->params['supportEmail'])
            ->setTo($order['email'])
            ->setSubject($subject)
            ->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Send Payment Failure Transaction
     * @param email
     * @return boolean
     */
    public function sendFailureEmail($order){
        try {
            $subject = 'Payment Failure Trasnaction';

            Yii::$app->mailer->compose('reminder-failure-html',[
                'content' => $order,
                ])
            ->setFrom(\Yii::$app->params['supportEmail'])
            ->setTo($order['email'])
            ->setSubject($subject)
            ->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
