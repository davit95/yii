<?php

namespace common\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveRecord;

/**
 * Model for ApiCredentials
 */
class ApiCredential extends ActiveRecord
{
    private $token;
    private $notification;

    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return '{{%api_credentials}}';
    }

    /**
    * get callback url from Storage
    */
    public function getCallbackUrl(){
        return static::find()->one()->callback_url;
    }

    /**
    * get callback $send_url from Storage for send OrderData
    */
    public function getSendUrl() {
        return static::find()->one()->send_url;
    }
    
    /**
    * get callback $return_url for send to WpMrpay
    */
    public function getReturnUrl(){
        return static::find()->one()->return_url;
    }
}
