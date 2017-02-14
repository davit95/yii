<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Order;
use common\models\Product;
use common\models\UserPlan;
use common\models\Transaction;
use common\models\Voucher;
use common\models\ResellerFee;

/**
 * Order controller
 */
class OrderController extends Controller
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
                        'actions' => [
                            'create-for-product',
                            'checkout',
                            'render-order-form'
                        ],
                        'roles' => ['user'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create-for-voucher'
                        ],
                        'roles' => ['reseller'],
                    ]
                ],
                'only' => [
                    'create-for-product',
                    'create-for-voucher',
                    'checkout',
                    'render-order-form'
                ]
            ],
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'create-for-product' => ['get'],
                    'create-for-voucher' => ['get'],
                    'checkout' => ['get'],
                    'render-order-form' => ['get']
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = [];

        foreach ($this->getPaymentMethods() as $pm) {
            if (class_exists($pm['gatewayClass'])) {
                $actions = ArrayHelper::merge($actions, $pm['gatewayClass']::actions());
            }
        }
        return $actions;
    }

    /**
     * Returns supported payment method
     *
     * Returns supported payment method.
     * Format of returned array is
     * [
     *   "payment_method_id" => [
     *     "id" => "Payment method id within payment gateway",
     *     "label" => "Patment method 1",
     *     "gatewayClass" => "PaymentGatewayClass"
     *   ]
     * ]
     *
     * @return array
     */
    private function getPaymentMethods()
    {
        return [
            'bitcoin' => [
                'id' => 'bitcoin',
                'label' => 'Bitcoin',
                'gatewayClass' => 'frontend\components\payments\GourlPaymentGateway'
            ],
            'sofortbanking' => [
                'id' => 'sofortbanking',
                'label' => 'Sofort',
                'gatewayClass' => 'frontend\components\payments\CuropaymentsPaymentGateway'
            ],
            'giropay' => [
                'id' => 'giropay',
                'label' => 'Giropay',
                'gatewayClass' => 'frontend\components\payments\CuropaymentsPaymentGateway'
            ],
            'ideal' => [
                'id' => 'ideal',
                'label' => 'iDeal',
                'gatewayClass' => 'frontend\components\payments\CuropaymentsPaymentGateway'
            ],
            'creditcard' => [
                'id' => 'creditcard',
                'label' => 'Credit card',
                'gatewayClass' => 'frontend\components\payments\CuropaymentsPaymentGateway'
            ]
        ];
    }

    /**
     * Creates new order and redirects to checkout
     *
     * @param  integer $id product id
     * @return mixed
     */
    public function actionCreateForProduct($id)
    {
        $user = Yii::$app->user->identity;

        $prod = Product::find()
            ->where(['id' => $id])
            ->andWhere(['status' => Product::STATUS_ACTIVE])
            ->one();

        if ($prod != null) {
            $order = new Order();
            $order->setScenario(Order::SCENARIO_CREATE);
            $order->user_id = $user->id;
            $order->cost = $prod->price;
            $order->currency = $prod->price_currency;
            $order->description = $prod->description;
            $order->product_id = $prod->id;
            $order->status = Order::STATUS_PENDING;

            if ($order->save()) {
                return $this->redirect(Url::to(['@order_checkout', 'id' => $order->id]));
            } else {
                return $this->redirect(Url::previous());
            }

        }

        throw new HttpException(500, 'Invalid product. Please try again later.');
    }

    /**
     * Creates new order
     *
     * @param  integer $voucher voucher id
     * @return mixed
     */
    public function actionCreateForVoucher($id)
    {
        $user = Yii::$app->user->identity;

        $voucher = Voucher::find()
            ->where(['id' => $id])
            ->andWhere(['issuer_id' => $user->id])
            ->one();

        $fee = ResellerFee::findByUser($user);

        if ($voucher != null) {
            $order = new Order();
            $order->setScenario(Order::SCENARIO_CREATE);
            $order->user_id = $user->id;
            if ($fee != null) {
                $order->cost = $fee->applyDiscount($voucher->product->price);
            } else {
                $order->cost = $voucher->product->price;
            }
            $order->currency = $voucher->product->price_currency;
            $order->description = $voucher->product->description;
            $order->product_id = $voucher->product->id;
            $order->status = Order::STATUS_PENDING;

            $order->addOrderData('voucher', $voucher->id);

            if ($order->save()) {
                return $this->redirect(Url::to(['@order_checkout', 'id' => $order->id]));
            } else {
                return $this->redirect(Url::previous());
            }

        }

        throw new HttpException(500, 'Invalid voucher. Please try again later.');
    }

    /**
     * Renders checkout form
     *
     * @return mixed
     */
    public function actionCheckout($id)
    {
        $pageRepo = Yii::$container->get('common\repositories\PagesRepository');

        $pageMeta = $pageRepo->getPageMetaData('order');
        $pageTitle = $pageRepo->getPageTitle('order');

        $user = Yii::$app->user->identity;

        $order = Order::find()
            ->where(['id' => $id])
            ->andWhere(['status' => Order::STATUS_PENDING])
            ->one();

        if ($order == null || $order->user->id != $user->id) {
            throw new NotFoundHttpException('Order not found.');
        }

        $this->layout = 'main';
        return $this->render('index', [
            'title' => $pageTitle,
            'meta' => $pageMeta,
            'order' => $order,
            'paymentMethods' => $this->getPaymentMethods()
        ]);
    }

    /**
     * Renders order form
     *
     * @return mixed
     */
    public function actionRenderOrderForm($orderId, $pmId)
    {
        Yii::$app->response->format = 'json';

        $user = Yii::$app->user->identity;

        $order = Order::find()
            ->where(['id' => $orderId])
            ->andWhere(['status' => Order::STATUS_PENDING])
            ->one();

        if ($order == null || $order->user->id != $user->id) {
            return [
                'success' => false,
                'message' => 'Order not found.'
            ];
        }

        foreach ($this->getPaymentMethods() as $id => $pm) {
            if ($id == $pmId) {
                if (class_exists($pm['gatewayClass'])) {
                    try {
                        $paymentGateway = new $pm['gatewayClass'];
                        $orderForm = $paymentGateway->renderOrderForm($order, $pm['id']);

                        return [
                            'success' => true,
                            'form' => $orderForm
                        ];
                    } catch (\Exception $e) {
                        Yii::error("Failed to create payment gateway class {$pm['gatewayClass']} or render order form.");
                    }
                }
            }
        }

        return [
            'success' => false,
            'message' => 'Payment method not found or payment gateway is not avaliable.'
        ];
    }
}
