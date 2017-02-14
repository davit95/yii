<?php

namespace app\models;
use yii\base\Model;
use Yii;
use common\models\User;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class ChangeModel extends Model
{

    public $oldpass;
    public $newpass;
    public $repeatnewpass;
    public $expiration_date;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['oldpass','newpass','repeatnewpass'],'required'],
                ['oldpass','findPasswords'],
                ['repeatnewpass','compare','compareAttribute'=>'newpass'],
                ['newpass', 'string', 'min' => 6, 'max' => 256, 'message' => 'password should be at least 6 symbols'],
        ];
    }


    public function attributeLabels(){
        return [
            'oldpass'=>'Old Password',
            'newpass'=>'New Password',
            'repeatnewpass'=>'Repeat New Password',
        ];
    }
    
    /**
    * Custom Validator
    */
    public function findPasswords($attribute, $params){
        $user = User::find()->where([
            'email'=>Yii::$app->user->identity->email
        ])->one();
        $password = $user->password_hash;
        if(!$user->validatePassword($this->oldpass)){
            $this->addError($attribute,'Old password is incorrect');
            return false;
        }
    }
}