<?php

namespace common\modules\api_v1\v1\ApiService;

use Yii;
use yii\base\Component;
use yii\base\InvalidParamException;
use common\models\ApiCredential;
use yii\di\Container;
use Carbon\Carbon;
use common\models\ApiUser;

class Auth extends Component
{
    protected $container;

    /**
    * Generate Token Method,use as Midelware
    * Token expiration time is 8 hour
    */
    public function GenerateToken(){
        $carbon = new Carbon();
        $api_user = new ApiUser;
        $api_user->token = $api_user->generateRandomToken();
        $api_user->refresh_token = $api_user->generateRandomToken();
        $api_user->expiration_date = $carbon->addHours(8);
        if($api_user->save()){
            return ['message'=>'success','token'=>$api_user->token,'refresh_token'=>$api_user->refresh_token,'expires'=>$api_user->expiration_date];
        }
    }

    /**
    * Refresh Token Method,use as Midelware
    * Refresh token with token and refresh token body params
    */
    public function RefreshToken(){
        $refresh_token = \Yii::$app->request->post('refresh_token');
        $token = \Yii::$app->request->post('token');
        if(null!=$refresh_token && null!=$token){
            $api_user = new ApiUser;
            $tokens = $api_user->RefreshToken($token,$refresh_token);
            if(null!=$tokens){
                return ['message'=>'success','token'=>$tokens->token,'refresh_token'=>$tokens->refresh_token,'expires'=>$tokens->expiration_date];   
            }else{
                return ['message'=>'Incorect Credentials'];
            }
        }else{
            return ['message'=>"error"];
        }
    }

    /**
    * @param string
    * @return boolean 
    */
    public function isExpired($token){
        $api_user = new ApiUser;
        $user = $api_user->getTokenByToken($token->token);
        if(strtotime(Carbon::parse($token->expiration_date)) - strtotime(Carbon::now()) > 0){
            return true;
        }else{
            return false;
        }
    }
}
