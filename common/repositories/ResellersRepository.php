<?php

namespace common\repositories;

use common\models\User;
use InvalidArgumentException;
use RuntimeException;
use Carbon\Carbon;
use common\models\ResellerFee;

/**
 * Class StatisticRepository
 *
 * @package common\repositories
 */
class ResellersRepository
{
    public function __construct(ResellerFee $reseller_fee,User $user){
        $this->reseller_fee = $reseller_fee;
        $this->user = $user;
    }

    /**
    * @return all resellers
    */
    public function showResellers(){
        return ResellerFee::find()->with('user')->asArray()->all();
    }

    /**
    * @param reseller user_id
    * @return new resellers resourse
    */
    public function deleteReseller($id){
        return $this->reseller_fee->findOne($id)->delete();
    }

    /**
    * @param reseller id
    * @return new resellers resourse
    */
    public function updateReseller($reseller){
        $data = $this->reseller_fee->find()->where(['id'=>$reseller['id']])->one();
        $data->amount = $reseller['amount'];
        $data->percent = $reseller['percent'];
        $data->status = $reseller['status'];
        $data->user_id = $reseller['user_id'];
        if($data->save(false)){
            return true;
        }
        return false;
    }

    /**
    * Store a newly created resource in storage.
    * get user Email By Id
    * Check if exists role reseller with this id
    * if exists create a new reseller fees
    * @param new resellers resourse
    */
    public function createReseller($data){
        $user_id = (null != $this->getUserIdbyEmail($data['email'])) ? $this->getUserIdbyEmail($data['email']) : null;
        $authManager = \Yii::$app->authManager;
        $user_with_role_reseller = User::find()
            ->where(['id'=>$user_id])
            ->andWhere(['in', 'id', $authManager->getUserIdsByRole('reseller')])
            ->all();
        if(null != $user_id && !empty($user_with_role_reseller)){
            $this->reseller_fee->user_id = $user_id;
            $this->reseller_fee->amount = $data['amount'];
            $this->reseller_fee->percent =$data['percent'];
            $this->reseller_fee->status = $data['status'];
            //id is required validation failed todo
            return $this->reseller_fee->save(false);
        }
        return false;
    }

    /**
    * @param user email address
    * @return user_id
    */
    private function getUserIdbyEmail($email){
        if(null != $user = $this->user->findOne(['email' => $email])){
            return $user->id;
        }
        return null;
    }

    /**
    * @param reseller_fee id
    * @return reseller with User relation
    */
    public function showResellerById($id){
        return $this->reseller_fee->find()->with('user')->asArray()->where(['id'=>$id])->one();
    }

    /**
    * @param reseller_fee id
    * @return user_id
    */
    public function getResellerEmailByUserId($id){
        if(null != $user = $this->user->findOne(['id' => $id])){
            return $user->id;
        }
        return null;
    }
}
