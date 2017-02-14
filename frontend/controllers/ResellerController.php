<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use yii\helpers\Url;
use common\models\Voucher;
use common\models\Product;
use common\models\ResellerFee;

/**
 * Reseller controller
 */
class ResellerController extends Controller
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
                        'roles' => ['reseller']
                    ]
                ]
            ],
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'my-account' => ['get'],
                    'vouchers' => ['get'],
                    'voucher' => ['get'],
                    'suspend-voucher' => ['post'],
                    'issue-voucher' => ['get', 'post'],
                    'products' => ['get'],
                    'pay-vouchers' => ['get'],
                    'pay-voucher' => ['get']
                ],
            ],
        ];
    }

    /**
     * Renders reseller account info
     *
     * @return mixed
     */
    public function actionMyAccount()
    {
        $user = Yii::$app->user->identity;

        $vouchersLimit = Yii::$app->config->get('Reseller.UnpayedVouchersLimit');

        $pageRepo = Yii::$container->get('common\repositories\PagesRepository');

        $pageMeta = $pageRepo->getPageMetaData('reseller-profile');
        $pageTitle = $pageRepo->getPageTitle('reseller-profile');

        $this->layout = 'reseller';
        return $this->render('myAccount', [
            'meta' => $pageMeta,
            'title' => $pageTitle,
            'vouchersLimit' => $vouchersLimit
        ]);
    }

    /**
     * Renders vouchers list
     *
     * @return mixed
     */
    public function actionVouchers()
    {
        $user = Yii::$app->user->identity;
        $vouchQuery = Voucher::find()->where(['issuer_id' => $user->id]);
        $vouchCountQuery = clone $vouchQuery;
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $vouchCountQuery->count(),
            'route' => Yii::getAlias('@reseller_vouchers')
        ]);

        $vouchQuery->orderBy(['created' => SORT_DESC]);
        $vouchQuery->offset($pagination->offset);
        $vouchQuery->limit($pagination->limit);

        $successMessage = Yii::$app->session->getFlash('successMessage', null);

        $pageRepo = Yii::$container->get('common\repositories\PagesRepository');

        $pageMeta = $pageRepo->getPageMetaData('reseller-vouchers');
        $pageTitle = $pageRepo->getPageTitle('reseller-vouchers');

        $this->layout = 'reseller';
        return $this->render('vouchers', [
            'meta' => $pageMeta,
            'title' => $pageTitle,
            'vouchers' => $vouchQuery->all(),
            'pag' => $pagination,
            'successMessage' => $successMessage
        ]);
    }

    /**
     * Renders voucher inform
     *
     * @param  integer $id
     * @return mixed
     */
    public function actionVoucher($id)
    {
        $user = Yii::$app->user->identity;
        $voucher = Voucher::find()
            ->where(['id' => $id])
            ->andWhere(['issuer_id' => $user->id])
            ->one();

        if ($voucher == null) {
            throw new NotFoundHttpException();
        }

        $pageRepo = Yii::$container->get('common\repositories\PagesRepository');

        $pageMeta = $pageRepo->getPageMetaData('reseller-voucher');
        $pageTitle = $pageRepo->getPageTitle('reseller-voucher');

        $this->layout = 'reseller';
        return $this->render('voucher', [
            'meta' => $pageMeta,
            'title' => $pageTitle,
            'voucher' => $voucher
        ]);
    }

    /**
     * Suspends voucher
     *
     * @return mixed
     */
    public function actionSuspendVoucher()
    {
        $id = Yii::$app->request->post('id', null);

        $voucher = Voucher::findOne($id);

        if ($voucher != null) {
            $user = Yii::$app->user->identity;

            if ($voucher->issuer->id == $user->id && $voucher->status == Voucher::STATUS_NOT_USED) {
                $voucher->setScenario(Voucher::SCENARIO_CREATE);
                $voucher->status = Voucher::STATUS_SUSPENDED;
                $voucher->save();
            }
        }

        return $this->redirect(Url::to(['@reseller_voucher','id' => $id]));
    }

    /**
     * Renders avaliabled products list
     *
     * @return mixed
     */
    public function actionProducts()
    {
        $user = Yii::$app->user->identity;
        $prodQuery = Product::find();
        $prodCountQuery = clone $prodQuery;
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $prodCountQuery->count(),
            'route' => Yii::getAlias('@reseller_products')
        ]);

        $prodQuery->orderBy(['name' => SORT_DESC]);
        $prodQuery->offset($pagination->offset);
        $prodQuery->limit($pagination->limit);

        $fee = ResellerFee::findByUser($user);

        $pageRepo = Yii::$container->get('common\repositories\PagesRepository');

        $pageMeta = $pageRepo->getPageMetaData('reseller-products');
        $pageTitle = $pageRepo->getPageTitle('reseller-products');

        $this->layout = 'reseller';
        return $this->render('products', [
            'meta' => $pageMeta,
            'title' => $pageTitle,
            'products' => $prodQuery->all(),
            'fee' => $fee,
            'pag' => $pagination
        ]);
    }

    /**
     * Renders issue voucher form and handles voucher creation
     *
     * @return mixed
     */
    public function actionIssueVoucher()
    {
        $vouchersLimit = Yii::$app->config->get('Reseller.UnpayedVouchersLimit');

        if (Yii::$app->request->isPost) {
            $user = Yii::$app->user->identity;
            $unpayedVouchersCount = Voucher::find()
                ->where(['issuer_id' => $user->id])
                ->andWhere(['<>', 'status', Voucher::STATUS_SUSPENDED])
                ->andWhere(['is_payed' => 0])
                ->count();
            $canIssue = $vouchersLimit > $unpayedVouchersCount;

            if ($canIssue) {
                $data = [];
                $data['issuer_id'] = Yii::$app->user->identity->id;
                $data['product_id'] = Yii::$app->request->post('product_id', null);
                $data['status'] = Voucher::STATUS_NOT_USED;

                $voucher = new Voucher();
                $voucher->setScenario(Voucher::SCENARIO_CREATE);
                $voucher->load($data, '');

                if ($voucher->save()) {
                    Yii::$app->session->setFlash('successMessage', 'Voucher created successfully.');
                    return $this->redirect(Url::to('@reseller_vouchers'));
                } else {
                    $errorMessage = 'Failed to issue voucher.';
                }
            }
        }

        $products = Product::find()->all();

        $pageRepo = Yii::$container->get('common\repositories\PagesRepository');

        $pageMeta = $pageRepo->getPageMetaData('reseller-issue-voucher');
        $pageTitle = $pageRepo->getPageTitle('reseller-issue-voucher');

        $this->layout = 'reseller';
        return $this->render('issueVoucher', [
            'meta' => $pageMeta,
            'title' => $pageTitle,
            'products' => $products,
            'vouchersLimit' => $vouchersLimit,
            'errorMessage' => (isset($errorMessage)) ? $errorMessage : null
        ]);
    }

    /**
     * Renders vouchers which can be payed
     *
     * @return mixed
     */
    public function actionPayVouchers()
    {
        $user = Yii::$app->user->identity;
        $vouchQuery = Voucher::find()
            ->with('product')
            ->where(['issuer_id' => $user->id])
            ->andWhere(['<>', 'status', Voucher::STATUS_SUSPENDED])
            ->andWhere(['is_payed' => 0]);
        $vouchCountQuery = clone $vouchQuery;
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $vouchCountQuery->count(),
            'route' => Yii::getAlias('@reseller_pay_vouchers')
        ]);

        $vouchQuery->orderBy(['created' => SORT_DESC]);
        $vouchQuery->offset($pagination->offset);
        $vouchQuery->limit($pagination->limit);

        $checkoutSuccessMessage = Yii::$app->session->getFlash('checkoutSuccessMessage', null);
        $checkoutErrorMessage = Yii::$app->session->getFlash('checkoutErrorMessage', null);

        $pageRepo = Yii::$container->get('common\repositories\PagesRepository');

        $pageMeta = $pageRepo->getPageMetaData('reseller-pay-vouchers');
        $pageTitle = $pageRepo->getPageTitle('reseller-pay-vouchers');

        $this->layout = 'reseller';
        return $this->render('payVouchers', [
            'meta' => $pageMeta,
            'title' => $pageTitle,
            'vouchers' => $vouchQuery->all(),
            'pag' => $pagination,
            'checkoutSuccessMessage' => $checkoutSuccessMessage,
            'checkoutErrorMessage' => $checkoutErrorMessage
        ]);
    }

    /**
     * Renders pay voucher page
     *
     * @param  integer $id voucher id
     * @return mixeds
     */
    public function actionPayVoucher($id)
    {
        $user = Yii::$app->user->identity;
        $voucher = Voucher::find()
            ->where(['id' => $id])
            ->andWhere(['issuer_id' => $user->id])
            ->andWhere(['<>', 'status', Voucher::STATUS_SUSPENDED])
            ->andWhere(['is_payed' => 0])
            ->one();

        if ($voucher == null) {
            throw new NotFoundHttpException();
        }

        $fee = ResellerFee::findByUser($user);

        $pageRepo = Yii::$container->get('common\repositories\PagesRepository');

        $pageMeta = $pageRepo->getPageMetaData('reseller-pay-voucher');
        $pageTitle = $pageRepo->getPageTitle('reseller-pay-voucher');

        $this->layout = 'reseller';
        return $this->render('payVoucher', [
            'meta' => $pageMeta,
            'title' => $pageTitle,
            'voucher' => $voucher,
            'fee' => $fee
        ]);
    }
}
