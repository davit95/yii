<?php

namespace service\components\filters\auth;

use Yii;
use service\components\identities\User;

/**
 * This auth filter allows authentication by using
 * username and password sended in Authorization HTTP header.
 */
class HttpBasicAuth extends \yii\filters\auth\HttpBasicAuth
{
    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->auth = function ($username, $password) {
            $client = Yii::$app->service->getAppClient();
            $resp = $client->authenticate($username, $password);
            if ($resp->isSuccess()) {
                if ($resp->body->success) {
                    return new User($resp->body->identity);
                }
            }

            return null;
        };
    }
}
