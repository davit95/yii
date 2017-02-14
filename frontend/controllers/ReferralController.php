<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpNotFoundException;
use common\models\ReferralLink;
use common\models\ReferralJournal;
use common\models\Transaction;
use frontend\Models\EarningsFilterForm;

/**
 * Handles user's referral related actions
 */
class ReferralController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors ()
    {
        return [
            'access' => [
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
     * Renders referal page
     *
     * @return mixed
     */
    public function actionIndex ()
    {
        $pageRepo = Yii::$container->get('common\repositories\PagesRepository');
        $pageMeta = $pageRepo->getPageMetaData('transaction');
        $pageTitle = $pageRepo->getPageTitle('transaction');

        $user = Yii::$app->user->identity;
        $refLinks = ReferralLink::find();
        $payments = Transaction::getTotalAmountPerMonthByUser($user, Transaction::TYPE_INCOMING);
        $refClicks = ReferralJournal::getRecordsByOwner($user, null, 'visit_page', null, null, false)->count('*');

        $this->layout = 'site';
        return $this->render('index',[
            'user' => $user,
            'refLinks' => $refLinks,
            'payments' => $payments,
            'refClicks' => $refClicks,
            'title'=>$pageTitle,
            'meta'=>$pageMeta
        ]);
    }

    /**
     * Renders referrals chart
     *
     * @param string $link referal link id
     * @param string $startDate date in yyyy-mm-dd format
     * @param string $endDate date in yyyy-mm-dd format
     * @return mixed
     */
    public function actionRenderEarnings ($link, $startDate, $endDate)
    {
        $form = new EarningsFilterForm();
        $form->refLinkId = $link;
        $form->startDate = $startDate;
        $form->endDate = $endDate;

        $resp = array();

        if ((list($link, $startDate, $endDate) = $form->prepareData()) !== false) {
            $resp['success'] = true;
        } else {
            $resp['success'] = false;
            $resp['errorHtml'] = $this->renderAjax('_alert', ['type' => 'error', 'message' => $form->getFirstErrors()]);
        }

        $resp['chartHtml'] = $this->renderAjax('_chart', ['refLink' => $link,'startDate' => $startDate,'endDate' => $endDate]);
        $resp['avgClicksPerDayHtml'] = $this->renderAjax('_avgClicksPerDay', ['refLink' => $link,'startDate' => $startDate,'endDate' => $endDate]);
        $resp['avgLeadsPerDayHtml'] = $this->renderAjax('_avgLeadsPerDay', ['refLink' => $link,'startDate' => $startDate,'endDate' => $endDate]);

        Yii::$app->response->format = 'json';
        return $resp;
    }

    /**
     * Sends invoice as PDF
     *
     * @return mixed
     */
    public function actionDownloadInvoice ()
    {
        $user = Yii::$app->user->identity;

        $transaction = $user->getTransactions()
            ->where(['type' => Transaction::TYPE_INCOMING])
            ->orderBy(['timestamp' => SORT_DESC])
            ->one();

        if ($transaction == null) {
            throw HttpNotFoundException();
        }

        $mpdf = new \mPDF('', 'A4', 0, 'dejavusans');

        $mpdf->WriteHTML($this->renderFile('@frontend/views/referral/_invoice.php', [
            'id' => $transaction->id,
            'transaction' => $transaction
        ]));

        return Yii::$app->response->sendContentAsFile(
            $mpdf->Output(null,'S'),
            'invoice.pdf',
            [
                'mimeType' => 'application/pdf',
                'inline' => false
            ]);
    }
}
