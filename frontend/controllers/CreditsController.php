<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use common\models\Product;
use frontend\models\VoucherForm;

/**
 * Handles user's credis actions
 */
class CreditsController extends Controller
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
                    ]
                ]
            ],
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'index' => ['get'],
                    'process-voucher' => ['post']
                ],
            ],
        ];
    }

    /**
     * Renders "Add credits" page
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $pageRepo = Yii::$container->get('common\repositories\PagesRepository');

        $pageMeta = $pageRepo->getPageMetaData('credits');
        $pageTitle = $pageRepo->getPageTitle('credits');

        $daysProducts = Product::findByType(Product::TYPE_DAILY)
            ->andWhere(['status' => Product::STATUS_ACTIVE])
            ->all();
        $limitProducts = Product::findByType(Product::TYPE_LIMITED)
            ->andWhere(['status' => Product::STATUS_ACTIVE])
            ->all();

        $plan = Yii::$app->user->identity->plan;

        $checkoutSuccessMessage = Yii::$app->session->getFlash('checkoutSuccessMessage', null);
        $checkoutErrorMessage = Yii::$app->session->getFlash('checkoutErrorMessage', null);

        $voucherSuccessMessage = Yii::$app->session->getFlash('voucherSuccessMessage', null);
        $voucherErrorMessage = Yii::$app->session->getFlash('voucherErrorMessage', null);

        //Save current URL to be able to go back if user cancels order
        Url::remember(Url::current());

        $this->layout = 'site';
        return $this->render('index', [
            'title' => $pageTitle,
            'meta' => $pageMeta,
            'plan' => $plan,
            'daysProducts' => $daysProducts,
            'limitProducts' => $limitProducts,
            'checkoutSuccessMessage' => $checkoutSuccessMessage,
            'checkoutErrorMessage' => $checkoutErrorMessage,
            'voucherSuccessMessage' => $voucherSuccessMessage,
            'voucherErrorMessage' => $voucherErrorMessage
        ]);
    }

    /**
     * Process voucher
     *
     * @return mixed
     */
    public function actionProcessVoucher()
    {
        $post = Yii::$app->request->post();
        $post['reCaptchaResp'] = Yii::$app->request->post('g-recaptcha-response', null);
        $voucherForm = new VoucherForm();

        $voucherForm->load($post, '');
        if ($voucherForm->process()) {
            Yii::$app->session->setFlash('voucherSuccessMessage', 'Voucher used successfully.');
        } else {
            Yii::$app->session->setFlash('voucherErrorMessage', $voucherForm->getFirstError());
        }

        return $this->redirect(Url::to('@profile_add_credits').'#voucher');
    }
}
