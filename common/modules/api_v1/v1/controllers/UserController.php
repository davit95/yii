<?php

namespace common\modules\api_v1\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use common\models\User;

/**
 * User controller
 */
class UserController extends Controller
{
    /**
     * @inheritdocs
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => $this->verbs(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function verbs()
    {
        return [
            'auth' => ['post']
        ];
    }

    /**
     * Authenticates user by provided username and password.
     * In case password is emtpy we assume that username
     * contains access token.
     *
     * @return mixed
     */
    public function actionAuth()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->response;

        $username = $request->post('username', null);
        $password = $request->post('password', null);

        if ($password !== null) {
            $user = User::findByEmail($username);
            if ($user && !$user->validatePassword($password)) {
                $user = null;
            }
        } else {
            $user = User::findIdentityByAccessToken($username);
        }

        if ($user != null) {
            $identity = [
                'id' => $user->id,
                'email' => $user->email,
                'roles' => $user->getRoles(true)
            ];
            return [
                'success' => true,
                'identity' => $identity
            ];
        } else {
            $response->setStatusCode(400);
            return [
                'success' => false,
                'message' => 'Authentication failed.'
            ];
        }
    }

}
