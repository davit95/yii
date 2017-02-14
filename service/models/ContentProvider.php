<?php

namespace service\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;

class ContentProvider extends ActiveRecord
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
        return '{{%content_providers}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'name' => 'Name',
            'class' => 'Class',
            'url_tpl' => 'URL template',
            'auth_url' => 'Auth (login) URL',
            'downloadable' => 'Downloadable',
            'streamable' => 'Streamable',
            'storable' => 'Storable',
            'use_proxy' => 'Use proxy',
            'status' => 'Status',
            'created' => 'Creation date',
            'updated' => 'Last update date'
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
            ['name', 'required'],
            ['name', 'string', 'min' => 1, 'max' => 100],
            ['class', 'required'],
            ['class', 'string', 'min' => 1, 'max' => 100],
            ['url_tpl', 'required'],
            ['url_tpl', 'string', 'min' => 1, 'max' => 200],
            ['auth_url', 'string', 'min' => 1, 'max' => 200],
            ['downloadable', 'required'],
            ['downloadable', 'boolean', 'trueValue' => 1, 'falseValue' => 0],
            ['streamable', 'required'],
            ['streamable', 'boolean', 'trueValue' => 1, 'falseValue' => 0],
            ['storable', 'required'],
            ['storable', 'boolean', 'trueValue' => 1, 'falseValue' => 0],
            ['use_proxy', 'required'],
            ['use_proxy', 'boolean', 'trueValue' => 1, 'falseValue' => 0],
            ['status', 'required'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
        ];
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated']
                ]
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'class' => 'class',
            'urlTpl' => 'url_tpl',
            'authUrl' => 'auth_url',
            'downloadable' => 'downloadable',
            'streamable' => 'streamable',
            'storable' => 'storable',
            'useProxy' => 'use_proxy',
            'status' => 'status',
            'created' => 'created',
            'updated' => 'updated'
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['name', 'class', 'url_tpl', 'auth_url', 'downloadable', 'streamable', 'storable', 'use_proxy', 'status'],
            self::SCENARIO_UPDATE => ['id', 'name', 'class', 'url_tpl', 'auth_url', 'downloadable', 'streamable', 'storable', 'use_proxy', 'status'],
            self::SCENARIO_DELETE => ['id']
        ];
    }

    /**
     * Returns content provider which url_tpl matches given url
     *
     * @param  string $url
     * @return ContentProvider|null
     */
    public static function guessByUrl($url)
    {
        $providers = static::find()->where(['status' => self::STATUS_ACTIVE]);

        foreach ($providers->each() as $provider) {
            if (preg_match('/'.$provider->url_tpl.'/', $url)) {
                return $provider;
            }
        }

        return null;
    }

    /**
     * Checks if contet of this provider can be downloaded
     *
     * Checks if contet of this provider can be downloaded.
     * Note that corresponding content class should use download behavior.
     *
     * @return boolean
     */
    public function isDownloadable()
    {
        return ((int)$this->downloadable === 1);
    }

    /**
     * Checks if contet of this provider can be streamed
     *
     * Checks if contet of this provider can be streamed.
     * Note that corresponding content class should use stream behavior.
     *
     * @return boolean
     */
    public function isStreamable()
    {
        return ((int)$this->streamable === 1);
    }

    /**
     * Checks if contet of this provider can be stored
     *
     * Checks if contet of this provider can be stored.
     * Note that corresponding content class should use store behavior.
     *
     * @return boolean
     */
    public function isStorable()
    {
        return ((int)$this->storable === 1);
    }

    /**
     * Checks if content provider uses proxy server
     *
     * Checks if content provider uses proxy server.
     * Note that corresponding content class should use anonymous behavior
     *
     * @return boolean
     */
    public function isUsingProxy()
    {
        return ((int)$this->use_proxy === 1);
    }

    /**
     * Returns content
     *
     * @param  Link|string $link
     * @return Content
     */
    public function getContent(Link $link)
    {
        if (!class_exists($this->class)) {
            throw new Exception('Content provider class not found.');
        }
        return new $this->class($link, $this);
    }

    /**
     * Returns credentials for content provider
     *
     * @return Credential[]
     */
    public function getCredentials()
    {
        return $this->hasMany(Credential::className(), ['id' => 'credential_id'])
            ->viaTable('{{%content_providers_credentials}}', ['content_provider_id' => 'id']);
    }

    /**
     * Returns random credential for content provider
     *
     * @return Credential|null
     */
    public function getCredential()
    {
        $activeCredentials = $this->getCredentials()->where(['status' => Credential::STATUS_ACTIVE]);

        $count = $activeCredentials->count();

        if ($count > 1) {
            //Use credential usage statistics to determinate most less used credential
            try {
                $statData = Yii::$app->statistic->get(
                    'times_credentials_used',
                    date('Y-m-d'),
                    date('Y-m-d'),
                    [['content_provider_id' => $this->id]]
                );
            } catch (Exception $e) {
                return $activeCredential->one();
            }

            $cred = null;
            $minUsage = INF;
            foreach ($activeCredentials->each() as $activeCredential) {
                $found = false;
                foreach ($statData as $data) {
                    if ($activeCredential->id == $data['credential_id']) {
                        $found = true;
                        if ($data['times_used'] < $minUsage) {
                            $minUsage = $data['times_used'];
                            $cred = $activeCredential;
                            break;
                        }
                    }
                }
                if (!$found) {
                    //No statistic found on usage of this credential, so it was not used yet.
                    return $activeCredential;
                }
            }

            return $cred;
        } else if ($count == 1) {
            return $activeCredentials->one();
        } else {
            return null;
        }
        /*
        Pick random credential
         if ($count > 0) {
            return $activeCredentials[rand(0, $count - 1)];
        } else {
            return null;
        }*/
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        if ($this->validate()) {
            try {
                $this->unlinkAll('credentials', true);
            } catch (\Exception $e) {
                return false;
            }
            return parent::delete();
        } else {
            return false;
        }
    }
}
