<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use \ReCaptcha\ReCaptcha;
use common\models\User;
use common\models\Voucher;
use common\models\Order;
use common\models\UserPlan;

class VoucherForm extends Model
{
    public $voucher;
    public $user_id;
    public $reCaptchaResp;

    /**
     * @inheritdoc
     */
    public function attributeLabels ()
    {
        return [
            'voucher' => 'Voucher',
            'user_id' => 'User',
            'reCaptchaResp' => 'Captcha'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            [['voucher', 'user_id', 'reCaptchaResp'], 'required'],
            ['voucher', 'string', 'min' => 1, 'max' => 40],
            ['voucher', 'exist', 'targetClass' => Voucher::className(), 'targetAttribute' => 'voucher', 'filter' => ['status' => Voucher::STATUS_NOT_USED]],
            ['user_id', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            ['user_id', 'validateUserPlan'],
            ['reCaptchaResp','validateReCaptchaResponse']
        ];
    }

    /**
     * Process voucher.
     *
     * @return bool true on success, false on failure
     */
    public function process ()
    {
        if ($this->validate()) {

            $user = User::findOne($this->user_id);
            $voucher = Voucher::findByCode($this->voucher);

            $transaction = Yii::$app->db->beginTransaction();

            $order = new Order();
            $order->setScenario(Order::SCENARIO_CREATE);
            $order->user_id = $user->id;
            $order->cost = $voucher->product->price;
            $order->currency = $voucher->product->price_currency;
            $order->description = $voucher->product->description;
            $order->product_id = $voucher->product->id;
            $order->voucher_id = $voucher->id;
            $order->status = Order::STATUS_COMPLETED;

            if ($order->save()) {
                $planUpdated = ($user->plan == null) ? UserPlan::create($user, $voucher->product) : $user->plan->applyProduct($voucher->product);

                if ($planUpdated) {
                    //Update voucher status
                    $voucher->setScenario(Voucher::SCENARIO_UPDATE);
                    $voucher->user_id = $this->user_id;
                    $voucher->used = time();
                    $voucher->status = Voucher::STATUS_USED;

                    if ($voucher->save()) {
                        $transaction->commit();
                        return true;
                    }
                }
            }

            $transaction->rollBack();
        }

        return false;
    }

    /**
     * Checks if user currently has active plan
     *
     * @return viod
     */
    public function validateUserPlan()
    {
        if (!$this->hasErrors()) {
            $user = User::findOne($this->user_id);

            $voucher = Voucher::findByCode($this->voucher);

            if ($user->plan != null && ($voucher->product->type != $user->plan->product_type)) {
                $this->addError('user_id', 'You currently have active plan. You may use this voucher after your plan will expire.');
            }
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

    /**
     * @inheritdoc
     */
    public function getFirstError($attribute = null)
    {
        if ($attribute == null) {
            $errors = $this->getErrors();
            return reset($errors)[0];
        }

        parent::getFirstError($attribute);
    }
}
