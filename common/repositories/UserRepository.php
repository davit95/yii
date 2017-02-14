<?php

namespace common\repositories;

use common\models\User;
use InvalidArgumentException;
use RuntimeException;

/**
 * Class UserRepository
 *
 * @package common\repositories
 */
class UserRepository
{
    /**
    * Create a new user repository instance.
    * @param User Model
    */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
    * Get all resources from storage.
    */
    public function getAllUsers()
    {
        return $this->user->find()->all();
    }


    /**
    * Get all resources from storage for Api Call.
    */
    public function getAllUsersApi()
    {
        $authManager = \Yii::$app->authManager;

        return User::find()
            ->ORwhere(['in', 'id', $authManager->getUserIdsByRole('user')])
            ->ORwhere(['in', 'id', $authManager->getUserIdsByRole('reseller')])
            ->all();
    }

    /**
    * Get specific resource from storage.
    */
    public function getUserByID($id)
    {
        $user = $this->user->find()->where(['id' => $id])->one();

        if (is_null($user)) {
            throw new InvalidArgumentException("Invalid user identifier,");
        }
        return $user;
    }

    /**
    * Get specific resource from storage.
    */
    public function getUserByEmail($email)
    {
        $user = $this->user->find()->where(['email' => $email])->one();
        return $user;
    }

    /**
    * Store a newly created resource in storage.
    * @param $params Array
    */
    public function createUser($params)
    {
        $this->user->email = $params['email'];
        $this->user->expiration_date = $params['expiration_date'];
        $this->user->access_token = $params['access_token'];
        $this->user->first_name = $params['first_name'];
        $this->user->last_name = $params['last_name'];
        $this->user->setPassword($params['password']);
        $this->user->generateAuthKey();

        if ($this->user->save()) {
            //Get role and assign it to user
            $authManager = \Yii::$app->authManager;
            $role = $authManager->getRole($params['role']);
            \Yii::$app->authManager->assign($role, $this->user->id);

            return $this->user;
        }

        throw new RuntimeException("User not created.");

    }

    /**
    * Store a newly created resource in storage.
    * @param $params Array
    */
    public function createUserForMrpayAccess($params)
    {
        $this->user->email = $params['email'];
        $this->user->setPassword($params['password']);
        $this->user->generateAuthKey();

        if ($this->user->save()) {
            return $this->user;
        }

        throw new RuntimeException("User not created.");

    }

    /**
    * Update a specific resource in storage.
    * @param $id ,$status string
    */
    public function updateUserStatus($id, $status)
    {
        $user = $this->getUserByID($id);
        $user->status = $status;
        if ($user->save()) {
            return $user;
        }

        throw new RuntimeException("Status not changed.");
    }

    /**
    * Delete specific resource from storage.
    */
    public function deleteUser($id)
    {
        $user = $this->getUserByID($id);
        return $user->delete();
    }

    /**
    * Get specific resource in storage.
    * user with active plan and plan type is daily
    */
    public function getUserWithActivePlan(){
        return $this->user->find()->where(['plan_status'=>'active'])->where(['limit'=>0])->all();
    }
}
