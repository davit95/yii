<?php

namespace service\components\identities;

use Yii;
use yii\base\Component;
use yii\web\IdentityInterface;

/**
 * Service user identity class
 */
class User extends Component implements IdentityInterface
{
    public $id;
    public $email;
    public $roles;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        //This method is currently not supported
        throw new \yii\base\NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($authKey, $type = null)
    {
        //This method is currently not supported
        throw new \yii\base\NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        //This method is currently not supported
        throw new \yii\base\NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        //This method is currently not supported
        throw new \yii\base\NotSupportedException();
    }

    /**
     * Returns user's roles
     *
     * @return string
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Returns true if user is admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return in_array('admin', $this->getRoles());
    }

}
