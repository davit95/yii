<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    const TERMS_TRUE = 1;
    const TERMS_FALSE = 0;

    public $email;
    public $password;
    public $confirmPass;
    public $expiration_date;
    public $access_token;
    public $role;
    public $terms = true;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['role', 'required'],
            ['role', function ($attribute, $param) {
                if (Yii::$app->authManager->getRole($this->role) == null) {
                    $this->addError($attribute, 'Invalid role specified.');
                }
            }],
            ['password', 'required'],
            ['terms','required','requiredValue' => true, "message" => 'Please Accept Terms of Service'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->email = $this->email;
        $user->expiration_date = $this->expiration_date;
        $user->access_token = $this->access_token;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if ($user->save()) {
            $authManager = Yii::$app->authManager;
            $role = $authManager->getRole($this->role);
            $authManager->assign($role, $user->id);

            return $user;
        }

        return null;
    }

}
