<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\HttpNotFoundException;
use common\models\Transaction;

/**
 * Handles user's funds transaction actions
 */
class TransactionController extends Controller
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
     * Renders list of user's transactions
     *
     * @return mixed
     */
    public function actionIndex ()
    {
        $pageRepo = Yii::$container->get('common\repositories\PagesRepository');

        $pageMeta = $pageRepo->getPageMetaData('transaction');
        $pageTitle = $pageRepo->getPageTitle('transaction');

        $user = Yii::$app->user->identity;
        $tranQuery = $user->getTransactions()->where(['type' => Transaction::TYPE_OUTGOING]);
        $tranCountQuery = clone $tranQuery;
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $tranCountQuery->count(),
            'route' => Yii::getAlias('@profile_my_transactions')
        ]);

        $tranQuery->orderBy(['timestamp' => SORT_DESC]);
        $tranQuery->offset($pagination->offset);
        $tranQuery->limit($pagination->limit);

        $this->layout = 'site';
        return $this->render('index', [
            'transactions' => $tranQuery->all(),
            'pag' => $pagination,
            'title'=>$pageTitle,
            'meta'=>$pageMeta
        ]);
    }

    /**
     * Sends invoice as PDF
     *
     * @return mixed
     */
    public function actionDownloadInvoice ($id)
    {
        $transaction = Transaction::findOne($id);

        if ($transaction == null) {
            throw HttpNotFoundException();
        }

        $mpdf = new \mPDF('', 'A4', 0, 'dejavusans');

        $mpdf->WriteHTML($this->renderFile('@frontend/views/transaction/_invoice.php', [
            'id' => $id,
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
