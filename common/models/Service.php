<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Exception;
use common\models\User;
use common\components\clients\service\Client;

/**
 * Model for services
 */
class Service extends ActiveRecord
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
        return '{{%services}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'uid' => 'Service UID',
            'url' => 'Service URL',
            'api_url' => 'Service API URL',
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
            ['id', 'exist', 'targetClass' => self::className(), 'targetAttribute' => 'id'],
            ['uid', 'required'],
            ['uid', 'string', 'min' => 1, 'max' => 10],
            ['url', 'required'],
            ['url', 'string', 'min' => 1, 'max' => 200],
            ['api_url', 'required'],
            ['api_url', 'string', 'min' => 1, 'max' => 200],
            ['status', 'required'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_ANACTIVE]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['uid', 'url', 'api_url', 'status'],
            self::SCENARIO_UPDATE => ['id', 'uid', 'url', 'api_url', 'status'],
            self::SCENARIO_DELETE => ['id']
        ];
    }

    /**
     * Returns service
     *
     * @return Service
     */
    public static function get()
    {
        $svcQuery = static::find()->where(['status' => self::STATUS_ACTIVE]);

        if ($svcQuery->count() == 1) {
            return static::find()->one();
        }

        $svc = null;
        $minConnNum = INF;
        foreach ($svcQuery->each() as $service) {
            $client = $service->getClientAsAdmin();
            $resp = $client->getSeviceConnectionsNumber();

            if ($resp->isSuccess()) {
                if ($minConnNum < $resp->body->connections_number) {
                    $svc = $service;
                    $minConnNum = $resp->body->connections_number;
                }
            }

            unset($client);
        }

        return $svc;
    }

    /**
     * Returns service client
     *
     * @param array $options options passed to client
     * @return Client
     */
    public function getClient($options = [])
    {
        if (!isset($options['auth'])) {
            //No auth data set, so try use current user's data
            if (!Yii::$app->user->isGuest) {
                $options = \yii\helpers\ArrayHelper::merge($options,
                    [
                        'auth' => [
                            'type' => 'bearer',
                            'accessToken' => Yii::$app->user->identity->access_token
                        ]
                    ]
                );
            }
        }

        return new Client($this->api_url, $options);
    }

    /**
     * Returns service client. Auth option is set to use admin user access token
     *
     * @return Client
     */
    public function getClientAsAdmin()
    {
        //Get admin user
        $authManager = Yii::$app->authManager;
        $user = User::find()
            ->where(['in', 'id', $authManager->getUserIdsByRole('admin')])
            ->one();

        if ($user == null) {
            throw new Exception('No user with \'admin\' role found.');
        }

        return $this->getClient(
            [
                'auth' => [
                    'type' => 'bearer',
                    'accessToken' => $user->access_token
                ]
            ]
        );
    }
}
