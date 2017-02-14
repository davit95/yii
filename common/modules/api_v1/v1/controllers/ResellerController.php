<?php

namespace common\modules\api_v1\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBasicAuth;
use common\models\User;
use common\models\Voucher;
use common\models\Product;

/**
 * Handles reseller actions
 */
class ResellerController extends Controller
{
    /**
     * @inheritdoc
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['reseller']
                    ]
                ]
            ],
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => $this->verbs(),
            ],
            'httpBasicAuth' => [
                'class' => HttpBasicAuth::className(),
                'auth' => function ($username, $password) {
                    $user = User::findByEmail($username);

                    if ($user != null && $user->validatePassword($password)) {
                        return $user;
                    }

                    return null;
                }
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function verbs()
    {
        return [
            'list-products' => ['get'],
            'list-vouchers' => ['get'],
            'create-voucher' => ['post'],
            'suspend-voucher' => ['put']
        ];
    }

    /**
     * Returns avaliable products list
     *
     * @return mixed
     */
    public function actionListProducts($offset = 0, $limit = 0)
    {
        $products = Product::find();

        $total = $products->count();

        if ($offset > 0) {
            $products->offset($offset);
        }
        if ($limit > 0) {
            $products->limit($limit);
        }

        return [
            'total' => $total,
            'count' => $products->count(),
            'products' => $products->all()
        ];
    }

    /**
     * Returns vouchers
     *
     * @param  integer $offst
     * @param  integer $limit
     * @return mixed
     */
    public function actionListVouchers($offset = 0, $limit = 0)
    {
        $issuer = Yii::$app->user->identity;

        $vouchers = Voucher::find()->where(['issuer_id' => $issuer->id]);

        $total = $vouchers->count();

        if ($offset > 0) {
            $vouchers->offset($offset);
        }
        if ($limit > 0) {
            $vouchers->limit($limit);
        }

        return [
            'total' => $total,
            'count' => $vouchers->count(),
            'vouchers' => $vouchers->all()
        ];
    }

    /**
     * Creates new voucher
     *
     * @return mixed
     */
    public function actionCreateVoucher()
    {
        $vouchersLimit = Yii::$app->config->get('Reseller.UnpayedVouchersLimit');

        $user = Yii::$app->user->identity;
        $unpayedVouchersCount = Voucher::find()
            ->where(['issuer_id' => $user->id])
            ->andWhere(['<>', 'status', Voucher::STATUS_SUSPENDED])
            ->andWhere(['is_payed' => 0])
            ->count();
        $canIssue = $vouchersLimit > $unpayedVouchersCount;

        if ($canIssue) {
            $product = Yii::$app->request->post('product', null);

            $voucher = new Voucher();
            $voucher->setScenario(Voucher::SCENARIO_CREATE);

            $voucher->product_id = $product;
            $voucher->issuer_id = Yii::$app->user->identity->id;
            $voucher->status = Voucher::STATUS_NOT_USED;

            if ($voucher->save()) {
                return [
                    'success' => true,
                    'voucher' => $voucher
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to create voucher.',
                    'errors' => $voucher->getErrors()
                ];
            }
        }

        return [
            'success' => false,
            'message' => 'You have reached limit of unpayed vouchers.'
        ];
    }

    /**
     * Sets voucher status to SUSPENDED
     *
     * @return mixed
     */
    public function actionSuspendVoucher()
    {
        $code = Yii::$app->request->post('voucher', null);
        $issuer = Yii::$app->user->identity;

        if (($voucher = Voucher::findByCodeAndIssuer($code, $issuer)) != null) {
            if ($voucher->status != Voucher::STATUS_USED) {
                $voucher->setScenario(Voucher::SCENARIO_UPDATE);
                $voucher->status = Voucher::STATUS_SUSPENDED;

                if ($voucher->save()) {
                    return [
                        'success' => true,
                        'voucher' => $voucher
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'Failed to suspend voucher.',
                        'errors' => $voucher->getErrors()
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'Voucher is already used and can\'t be suspended.'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Voucher not found.'
            ];
        }
    }
}
