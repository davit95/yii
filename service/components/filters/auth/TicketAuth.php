<?php

namespace service\components\filters\auth;

use Yii;
use yii\filters\auth\AuthMethod;
use yii\web\UnauthorizedHttpException;
use yii\helpers\Url;
use service\components\identities\User;

/**
 * Ticket authorization
 *
 * How this works:
 *
 * When user tries to download or stream content from service
 * He should send ticket parameter as URL param.
 *
 * Ticket is fetched from URL.
 * Ticket validation is performed.
 *
 * If ticket is valid response contains basic user identity info.
 * So user identity can be populated and can be used across service.
 *
 * If ticket is not valid (i.e. expired) attempt to renew ticket is performed.
 * Service prompts user for login and password after what ticket/renew API method
 * is called.
 * On success new ticket is sent in response and user is redirected to same URL
 * but containing updated ticket param.
 */
class TicketAuth extends AuthMethod
{
    private $ticket;

    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $ticket = $request->get('ticket', null);

        if ($ticket !== null) {
            $client = Yii::$app->service->getAppClient();
            $resp = $client->validateTicket($ticket);

            if ($resp->isSuccess()) {
                if ($resp->body->success) {
                    $data = $resp->body->user;

                    $identity = new User([
                        'id' => $data->id,
                        'email' => $data->email,
                        'roles' => $data->roles
                    ]);
                    if ($user->login($identity)) {
                        return $identity;
                    }
                } else {
                    //Try to send renew request
                    $username = $request->getAuthUser();
                    $password = $request->getAuthPassword();

                    if ($username != null && $password != null) {
                        $client = Yii::$app->service->getAppClient([
                            'auth' => [
                                'type' => 'basic',
                                'username' => $username,
                                'password' => $password
                            ]
                        ]);
                        $resp = $client->renewTicket();

                        if ($resp->isSuccess()) {
                            if ($resp->body->success) {
                                $this->ticket = $resp->body->ticket;
                                $this->handleFailure($response);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function handleFailure($response)
    {
        if ($this->ticket != null) {
            //Redirect user to URL containing new ticket
            return $response->redirect(Url::current(['ticket' => $this->ticket], true));
        }

        throw new UnauthorizedHttpException('You are requesting with an invalid credential.');
    }

    /**
     * @inheritdoc
     */
    public function challenge($response)
    {
        $response->getHeaders()->set('WWW-Authenticate', "Basic realm=\"service\"");
    }
}
