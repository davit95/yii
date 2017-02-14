<?php

namespace common\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveRecord;
use Carbon\Carbon;

class ApiUser extends ActiveRecord
{
    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return '{{%api_users}}';
    }

    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ]
            ],
            [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
            ],
        ];
    }

    /**
    * Generate Random Token for Api auth
    */
    public function generateRandomToken(){
        return $token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
    * Get All tokens from storage
    */
    public function getAllTokens(){
        return static::find()->all();
    }

    /**
    * Get Token by Id
    */
    public function getTokenByToken($token){
        return static::find()->where(['token'=>$token])->one();
    }

    /**
    * Refresh Token if token expired 
    * @param  random $post_token string, random $refresh_token string
    */
    public function RefreshToken($post_token,$refresh_token){
        $token_field = static::find()->where(['token'=>$post_token])->where(['refresh_token'=>$refresh_token])->one();
        if(null!=$token_field){
            $token_field->expire = "no_expired";
            $token_field->token = Yii::$app->security->generateRandomString() . '_' . time();
            $token_field->refresh_token = Yii::$app->security->generateRandomString() . '_' . time();
            $date = Carbon::now()->addHours(8);
            $token_field->expiration_date = $date;
            if($token_field->save()){
                return $token_field; 
            }else{
                return 'error occured';
            }
        }else{
            return null;
        }
    }
}
