<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use \ReCaptcha\ReCaptcha;

class ContactForm extends Model
{
    public $email;
    public $subject;
    public $message;
    public $reCaptchaResp;

    /**
     * @inheritdoc
     */
    public function attributeLabels ()
    {
        return [
            'email' => 'E-mail address',
            'subject' => 'Subject',
            'message' => 'Message',
            'reCaptchaResp' => 'Captcha'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            [['email', 'subject', 'message', 'reCaptchaResp'], 'required'],
            ['email', 'email'],
            ['subject','string','min' => 1],
            ['message','string','min' => 1],
            ['reCaptchaResp','validateReCaptchaResponse']
        ];
    }

    /**
     * Send email to admininstation via contact form.
     *
     * @return bool true on success, false on failure
     */
    public function send ()
    {
        if ($this->validate()) {
            $contactEmail = Yii::$app->config->get('App.ContactEmail');

            return Yii::$app->mailer->compose([
                'html' => 'contactUs-html',
                'text' => 'contactUs-text'
            ],[
                'message' => $this->message
            ])
            ->setFrom($this->email)
            ->setTo($contactEmail)
            ->setSubject($this->subject)
            ->send();
        } else {
            return false;
        }
    }

    /**
     * Validate Google recaptcha response.
     *
     * @return void
     */
    public function validateReCaptchaResponse ()
    {
        if (!$this->hasErrors()) {
            $reCaptcha = new ReCaptcha(Yii::$app->config->get('GoogleReCaptcha.SecretKey'));
            $reCaptchaResp = $reCaptcha->verify($this->reCaptchaResp, $_SERVER['REMOTE_ADDR']);
            if (!$reCaptchaResp->isSuccess()) {
                $this->addError('recaptchaResponse','Invalid captcha');
            }
        }
    }
}
