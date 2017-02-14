<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\Host;
use common\models\Service;
use common\models\UnrestrainedLink;
use common\models\DownloadJournal;
use common\models\Product;
use frontend\models\UnrestrainLinksForm;

/**
 * Handles user's downloads
 */
class DownloadController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['user', 'admin']
                    ],
                ]
            ],
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'links-list' => ['get'],
                    'unrestrain-link' => ['post'],
                    'delete-unrestrain-link' => ['post']
                ],
            ],
        ];
    }

    /**
     * Renders download page
     *
     * @return mixed
     */
    public function actionDownload()
    {
        $pageRepo = Yii::$container->get('common\repositories\PagesRepository');

        $pageMeta = $pageRepo->getPageMetaData('download');
        $pageTitle = $pageRepo->getPageTitle('download');

        $user = Yii::$app->user->identity;

        $limitedHosts = Host::getLimited();

        $plan = $user->plan;

        if ($plan != null && $plan->isActive()) {
            if ($plan->product_type == Product::TYPE_DAILY) {
                $daysUsed = (int)floor((time() - $plan->start) / 86400);
                $daysLeft = (int)$plan->days - $daysUsed;
            }

            $bytesDownloaded = DownloadJournal::getBytesSendedToUser($user, $plan->start);
        }

        $this->layout = 'site';
        return $this->render('download', [
            'daysUsed' => isset($daysUsed) ? $daysUsed : null,
            'daysLeft' => isset($daysLeft) ? $daysLeft : null,
            'bytesDownloaded' => isset($bytesDownloaded) ? $bytesDownloaded : null,
            'limitedHosts' => $limitedHosts,
            'title' => $pageTitle,
            'meta' => $pageMeta
        ]);
    }

    /**
     * Renders links list
     *
     * @return mixed
     */
    public function actionLinksList()
    {
        $form = new UnrestrainLinksForm();
        $form->load(Yii::$app->request->get(), '');

        $password = Yii::$app->request->get('password', null);

        $resp = array();

        $plan = Yii::$app->user->identity->plan;

        if ($plan != null && $plan->isActive()) {
            if (($links = $form->prepareData()) !== false) {
                $resp['success'] = true;
                $resp['linksListHtml'] = $this->renderAjax('_linksList', [
                  'links' => $links,
                  'password' => $password,
                  'pending' => true ]
                );
            } else {
                $resp['success'] = false;
                $resp['linksListHtml'] = $this->renderAjax('_linksList', [
                  'error' => true,
                  'message' => 'Invalid links provided.']
                );
            }
        } else {
            //If user has no active  plan - show error
            $resp['success'] = false;
            $resp['linksListHtml'] = $this->renderAjax('_linksList', [
              'error' => true,
              'message' => 'You need to be premium to unrestrain your links.']
            );
        }

        Yii::$app->response->format = 'json';
        return $resp;
    }

    /**
     * Renders unrestrained link block
     *
     * @return link
     */
    public function actionUnrestrainLink()
    {
        $link = Yii::$app->request->post('link', null);
        $password = Yii::$app->request->post('password', null);
        $user = Yii::$app->user->identity;

        Yii::$app->response->format = 'json';

        $service = Service::get();

        if ($service != null) {
            $client = $service->getClient();
            $resp = $client->createLink($link, $user->id, $password);

            if ($resp->isSuccess()) {
                $linkData = [
                    'user_id' => $user->id,
                    'download_link' => $resp->body->downloadLink,
                    'stream_link' => $resp->body->streamLink,
                    'content_name' => $resp->body->contentName,
                    'content_size' => $resp->body->contentSize,
                ];

                $unrestrainedLink = new UnrestrainedLink();
                $unrestrainedLink->setScenario(UnrestrainedLink::SCENARIO_CREATE);
                $unrestrainedLink->load($linkData, '');
                if ($unrestrainedLink->save()) {
                    $success = true;
                } else {
                    $success = false;
                }
            } else {
                $success = false;
            }

            if ($success) {
                return [
                    'success' => true,
                    'linkHtml' => $this->renderAjax('_unrestrainedLink', ['unrestrainedLink' => $unrestrainedLink])
                ];
            } else {
                return [
                    'success' => false,
                    'linkHtml' => $this->renderAjax('_invalidLink', ['link' => $link, 'error' => 'Failed to unrestrain link.'])
                ];
            }
        } else {
            return [
                'success' => false,
                'linksListHtml' => $this->renderAjax('_linksList', [
                    'error' => true,
                    'message' => 'No active services found. Please, try again later.'
                ])
            ];
        }
    }

    /**
     * Renders my downloads page
     *
     * @return mixed
     */
    public function actionMyDownloads()
    {
        $pageRepo = Yii::$container->get('common\repositories\PagesRepository');
        $pageMeta = $pageRepo->getPageMetaData('my-downloads');
        $pageTitle = $pageRepo->getPageTitle('my-downloads');

        $user = Yii::$app->user->identity;
        $unrestLinksQuery = UnrestrainedLink::find()->where(['user_id' => $user->id]);
        $unrestLinksCountQuery = clone $unrestLinksQuery;

        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $unrestLinksCountQuery->count(),
            'route' => Yii::getAlias('@profile_my_downloads')
        ]);

        $unrestLinksQuery->orderBy(['created' => SORT_DESC]);
        $unrestLinksQuery->offset($pagination->offset);
        $unrestLinksQuery->limit($pagination->limit);

        $this->layout = 'site';
        return $this->render('myDownloads', [
            'unrestrainedLinks' => $unrestLinksQuery->all(),
            'pag' => $pagination,
            'title'=>$pageTitle,
            'meta'=>$pageMeta
        ]);
    }

    /**
     * Deletes unrestrained link
     *
     * @return mixed
     */
    public function actionDeleteUnrestrainedLink()
    {
        $id = Yii::$app->request->post('id', null);
        $user = Yii::$app->user->identity;

        $unrestrainedLink = UnrestrainedLink::find()
            ->where(['id' => $id])
            ->andWhere(['user_id' => $user->id])
            ->one();

        Yii::$app->response->format = 'json';

        if ($unrestrainedLink) {
            $unrestrainedLink->setScenario(UnrestrainedLink::SCENARIO_DELETE);
            if ($unrestrainedLink->delete()) {
                return [
                    'success' => true,
                    'message' => 'Link deleted successfully.'
                ];
            }
        }
        return [
            'success' => false,
            'message' => 'Failed to delete link.'
        ];
    }
}
