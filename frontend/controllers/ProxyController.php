<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Ticket;
use common\models\UnrestrainedLink;
use common\models\DownloadJournal;
use common\models\UserPlan;
use common\models\Product;

/**
 * Proxy controller.
 *
 * How this works:
 * User visits URL which is mapped to this controller action.
 * If user is guest and using browser he is redirected to login page.
 * If user is guest but uses download manager HTTP basic auth window will popup.
 * NOTE: Some download managers fake User-Agent HTTP header so we are not able to
 * detect if it's a browser or download manager.
 *
 * If user is logged in and has no active plan he is redirected to "add credits" page.
 * Same happends if user has active plan but it is expired.
 *
 * If user is logged in an has valid active plan new ticket is generated
 * and user is redirected to download service URL containing ticket as param.
 *
 * @see common\modules\api_v1\v1\controllers\TicketController
 * @see service\components\filters\auth\TicketAuth
 */
class ProxyController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'httpBasicAuth' => [
                'class' => 'yii\filters\auth\HttpBasicAuth',
                'auth' => function($username, $password) {
                    $user = User::findByEmail($username);

                    if ($user && $user->validatePassword($password)) {
                        return $user;
                    }

                    return null;
                }
            ],
            'accessControl' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['user', 'admin']
                    ]
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        /**
         * Do some magic.
         * If user is already logged in or user uses web browser
         * we need to detach HttpBasicAuth behavior.
         * And not confuse user with credentials popup window.
         * Since some download managers may fake User-Agent header
         * we also should check if credentials are not send via HTTP headers.
         */
        $username = Yii::$app->request->getAuthUser();
        $password = Yii::$app->request->getAuthPassword();

        if (!Yii::$app->user->isGuest || (preg_match('/(firefox|chrome|msie|safari)/i', Yii::$app->request->getUserAgent()) && $username === null && $password === null)) {
            $this->detachBehavior('httpBasicAuth');
        }

        //Delete expired tickets
        Ticket::deleteExpired();

        return parent::beforeAction($action);
    }

    /**
     * Convers request headers to query string
     *
     * @return string
     */
    private function processHeaders()
    {
        $query = [];

        //Proces HTTP Range headers
        if (isset($_SERVER['HTTP_RANGE'])) {
            if (preg_match('/^bytes=(\d*)-(\d*)$/', $_SERVER['HTTP_RANGE'], $matches)) {
                $query['range'] = $matches[1].'-'.$matches[2];
            }
        }

        return $query;
    }

    /**
     * Checks if user can proceed to download\stream
     *
     * @param  User $user
     * @param  UnrestrainedLink $link
     * @return boolean
     */
    private function canProceed($user, $link)
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

                if ($plan->getLimitInBytes() >= ($bytesSended + $link->content_size)) {
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
     * Prepares request and redirects to download URL
     *
     * @param  string $hash
     * @return mixed
     */
    public function actionProcessDownload($hash)
    {
        $user = Yii::$app->user->identity;

        //Find link
        $link = UnrestrainedLink::findByHash($hash);

        if ($link == null) {
            throw new NotFoundHttpException('Page not found.');
        }

        //Create new ticket
        $ticket = new Ticket();
        $ticket->setScenario(Ticket::SCENARIO_CREATE);
        $ticket->setOwner($user);
        if (!$ticket->save()) {
            Yii::error('Failed to create ticket.');
            throw new HttpException(500, 'Internal server error occured. Please try again later.');
        }

        //Proxy HTTP headers
        $query = ArrayHelper::merge(['ticket' => $ticket->ticket], $this->processHeaders());

        if ($this->canProceed($user, $link)) {
            return $this->redirect($link->download_link.'?'.http_build_query($query, '', '&', PHP_QUERY_RFC3986));
        } else {
            return $this->redirect(Url::to(['/credits']));
        }
    }

    /**
     * Prepares request and redirects to stream URL
     *
     * @param  string $hash
     * @return mixed
     */
    public function actionProcessStream($hash)
    {
        $user = Yii::$app->user->identity;

        //Find link
        $link = UnrestrainedLink::findByHash($hash);

        if ($link == null) {
            throw new NotFoundHttpException('Page not found.');
        }

        //Create new ticket
        $ticket = new Ticket();
        $ticket->setScenario(Ticket::SCENARIO_CREATE);
        $ticket->setOwner($user);
        if (!$ticket->save()) {
            Yii::error('Failed to create ticket.');
            throw new HttpException(500, 'Internal server error occured. Please try again later.');
        }

        //Proxy HTTP headers
        $query = ArrayHelper::merge(['ticket' => $ticket->ticket], $this->processHeaders());

        //Go to stream
        if ($this->canProceed($user, $link)) {
            return $this->redirect($link->stream_link.'?'.http_build_query($query, '', '&', PHP_QUERY_RFC3986));
        } else {
            return $this->redirect(Url::to(['/credits']));
        }
    }

}
