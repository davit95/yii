<?php

namespace service\components\filters\auth;

use Yii;
use service\components\identities\User;

/**
 * This auth filter allows authentication by using
 * access token sended in Authorization HTTP header.
 */
class HttpBearerAuth extends \yii\filters\auth\HttpBearerAuth
{
    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('Authorization');
        if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $client = Yii::$app->service->getAppClient();
            $resp = $client->authenticate($matches[1]);
            if ($resp->isSuccess()) {
                if ($resp->body->success) {
                    $identity = new User($resp->body->identity);
                    $user->switchIdentity($identity);
                    return $identity;
                }
            }

            $this->handleFailure($response);
        }

        return null;
    }
}
