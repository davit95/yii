<?php

namespace service\models;

use Yii;
use yii\db\ActiveRecord;

class Credential extends ActiveRecord
{
    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_UPDATE = 'UPDATE';
    const SCENARIO_DELETE = 'DELETE';

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%credentials}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user' => 'Username',
            'pass' => 'Password',
            'status' => 'Status'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'exist', 'targetClass' => static::className(), 'targetAttribute' => 'id'],
            ['user', 'required'],
            ['user', 'string', 'min' => 1, 'max' => 500],
            ['pass', 'required'],
            ['pass', 'string', 'min' => 1, 'max' => 500],
            ['status', 'required'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id' => 'id',
            'user' => 'decryptedUser',
            'pass' => 'decryptedPass',
            'status' => 'status'
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['user', 'pass', 'status'],
            self::SCENARIO_UPDATE => ['id', 'user', 'pass', 'status'],
            self::SCENARIO_DELETE => ['id']
        ];
    }

    /**
     * @inheritdoc
     */
    public function setAttributes($data, $formName = null)
    {
        if (isset($data['user'])) {
            $data['user'] = $this->encrypt($data['user']);
        }
        if (isset($data['pass'])) {
            $data['pass'] = $this->encrypt($data['pass']);
        }

        return parent::setAttributes($data, $formName);
    }

    /**
     * Returnd decrypted username.
     * Only for backward compatibility.
     * Use getDecryptedUser() method instead.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->decrypt($this->user);
    }

    /**
     * Returns decrypted password
     * Only for backward compatibility.
     * Use getDecryptedPassword() method instead.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->decrypt($this->pass);
    }

    /**
     * Sets and encrypts user
     *
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $this->encrypt($user);
    }

    /**
     * Sets and encrypts password
     *
     * @param string $pass
     */
    public function setPass($pass)
    {
        $this->pass = $this->encrypt($pass);
    }

    /**
     * Returnd decrypted user
     *
     * @return string
     */
    public function getDecryptedUser()
    {
        return $this->decrypt($this->user);
    }

    /**
     * Returns decrypted password
     *
     * @return string
     */
    public function getDecryptedPass()
    {
        return $this->decrypt($this->pass);
    }

    /**
     * Returns encrypted using encryptKey data
     *
     * @param  string $data
     * @return string
     */
    private function encrypt($data)
    {
        $key = Yii::$app->service->getParam('encryptKey');
        return utf8_encode(Yii::$app->security->encryptByKey($data, $key));
    }

    /**
     * Returns decrypted data
     *
     * @param  string $data
     * @return string
     */
    private function decrypt($data)
    {
        $key = Yii::$app->service->getParam('encryptKey');
        return Yii::$app->security->decryptByKey(utf8_decode($data), $key);
    }

    /**
     * Returns content providers which use this credentials
     *
     * @return ContentProvider[]
     */
    public function getContentProviders()
    {
        return $this->hasMany(ContentProvider::className(), ['id' => 'content_provider_id'])
            ->viaTable('{{%content_providers_credentials}}', ['credential_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        if ($this->validate()) {
            try {
                $this->unlinkAll('contentProviders', true);
            } catch (\Exception $e) {
                return false;
            }
            return parent::delete();
        } else {
            return false;
        }
    }
}
