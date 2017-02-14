<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%users}}";
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }


    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function loginByAccessToken($token)
    {
        return Yii::$app->user->loginByAccessToken($token);
    }

    public function actionAccessTokenByUser($email, $passwordHash)
    {
        $accessToken = null;
        $user = \common\models\User::findOne(['email' => $email,
        'password_hash' => $passwordHash]);
        if($user!=null)
        {
            $user->access_token = Yii::$app->security->generateRandomString();
            $user->save();
            $accessToken = $user->access_token;
        }
        return [ 'access-token' => $accessToken ];
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Returns user's full name
     *
     * @return string|null
     */
    public function getFullName()
    {
        if ($this->first_name == null && $this->last_name == null) {
            return null;
        }

        return trim($this->first_name.' '.$this->last_name);
    }

    /**
     * Returns list of user roles
     *
     * @param  boolean $asArray
     * @return Role[]|array
     */
    public function getRoles($asArray = false)
    {
        $authManager = Yii::$app->authManager;
        $roles = $authManager->getRolesByUser($this->id);

        if ($asArray) {
            $_roles = [];
            foreach ($roles as $role) {
                $_roles[] = $role->name;
            }
            return $_roles;
        }

        return $roles;
    }

    /**
     * Checks if user has role
     *
     * @param  Role|string  $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if ($role instanceof yii\rbac\Role) {
            $roleName = $role->name;
        } else {
            $roleName = $role;
        }

        return in_array($roleName, $this->getRoles(true));
    }

    /**
     * Grants referral points to user
     *
     * @param  integer $points
     * @return void
     */
    public function grantReferralPoints($points)
    {
        $this->referral_points += (int)$points;
    }

    /**
     * Returns user's funds transactions
     *
     * @return Transaction[]
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['user_id' => 'id']);
    }

    /**
     * Returns user's Product
     *
     * @return Product[]
     */
    public function getProducts()
    {
        return $this
            ->hasMany(Product::className(), ['id' => 'product_id'])
            ->viaTable(UserProductJournal::tableName(), ['user_id' => 'id']);
    }

    /**
     * Returns user's plan
     *
     * @return UserPlan
     */
    public function getPlan()
    {
        return $this->hasOne(UserPlan::className(), ['user_id' => 'id']);
    }

    /**
     * Returns user's orders
     *
     * @return Order[]
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['user_id' => 'id']);
    }

}
