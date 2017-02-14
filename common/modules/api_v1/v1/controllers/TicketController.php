<?php

namespace common\modules\api_v1\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use Carbon\Carbon;
use common\models\User;
use common\models\Ticket;
use common\models\DownloadJournal;
use common\models\UserPlan;
use common\models\Product;

/**
 * Ticket controller.
 *
 * How this works:
 * This controller is ment to handle two actions:
 * - Validate ticket
 * - Renew ticket
 *
 */
class TicketController extends Controller
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
            'httpBasicAuth' => [
                'class' => 'yii\filters\auth\HttpBasicAuth',
                'auth' => function ($username, $password) {
                    $user = User::findByEmail($username);

                    if ($user != null && $user->validatePassword($password)) {
                        if ($user->hasRole('user') || $user->hasRole('admin')) {
                            return $user;
                        }
                    }

                    return null;
                },
                'only' => ['renew']
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
            'validate' => ['get'],
            'renew' => ['get']
        ];
    }

    /**
     * Checks if user can proceed to download\stream.
     *
     * @param  User $user
     * @return boolean
     */
    private function canProceed($user)
    {
        $canProceed = false;

        $plan = $user->plan;

        if ($plan != null && $plan->isActive()) {
            if ($plan->product_type == Product::TYPE_DAILY) {
                //If user's plan is daily, check if it's not exipred
                if ($plan->expire >= time()) {
                    $canProceed = true;
                }
            } else if ($plan->product_type == Product::TYPE_LIMITED) {
                //If user's plan is limited check if user has enought limit to download file
                $bytesSended = DownloadJournal::getBytesSendedToUser($user, $plan->start);

                if ($plan->getLimitInBytes() >= $bytesSended) {
                    $canProceed = true;
                }
            }

            if (!$canProceed && $plan != null && $plan->isActive()) {
                //User's plan is expired. Update it
                $plan->setScenario(UserPlan::SCENARIO_UPDATE);
                $plan->status = UserPlan::STATUS_EXPIRED;
                $plan->save();
            }
        }

        return $canProceed;
    }

    /**
     * Validates ticket
     *
     * @param  string $ticket
     * @return mixed
     */
    public function actionValidate($ticket)
    {
        $response = Yii::$app->response;

        $tkt = Ticket::findByTicket($ticket);

        if ($tkt != null) {
            if ($tkt->isExpired()) {
                return [
                    'success' => false,
                    'message' => 'Ticket is expired.'
                ];
            }

            $owner = $tkt->owner;

            if (!$this->canProceed($owner)) {
                return [
                    'success' => false,
                    'message' => 'User\'s plan is expired.'
                ];
            }

            $identity = [
                'id' => $owner->id,
                'email' => $owner->email,
                'roles' => $owner->getRoles(true),
            ];

            return [
                'success' => true,
                'user' => $identity
            ];
        }

        return [
            'success' => false,
            'message' => 'Invalid ticket.'
        ];
    }

    /**
     * Renews donwload ticket
     *
     * @return mixed
     */
    public function actionRenew()
    {
        $response = Yii::$app->response;

        $user = Yii::$app->user->identity;

        //Check if user plan allows to download more..
        if ($this->canProceed($user)) {
            $ticket = new Ticket();
            $ticket->setScenario(Ticket::SCENARIO_CREATE);
            $ticket->setOwner($user);
            if ($ticket->save()) {
                return [
                    'success' => true,
                    'ticket' => $ticket->ticket
                ];
            }
        }

        return [
            'success' => false,
            'message' => 'Failed to renew ticket.'
        ];
    }
}
