<?php

namespace frontend\components\payments\actions\curopayments;

use Yii;
use yii\base\Action;
use yii\helpers\Url;
use common\models\Order;
use common\models\Transaction;
use common\models\UserPlan;
use common\models\Voucher;
use frontend\components\payments\CuropaymentsPaymentGateway;

class CallbackUrlHandler extends Action
{
    /**
     * Handles callback url request from curopayments
     *
     * @return mixed
     */
    public function run()
    {
        $curoGateway = new CuropaymentsPaymentGateway();

        $data = Yii::$app->request->get();
        $dataString = print_r($data, true);

        if ($curoGateway->isValidResponse($data)) {
            $order = Order::findOne($data['reference']);

            if ($order != null && $order->status == Order::STATUS_PENDING) {
                $user = $order->user;

                if ($data['code'] == 200 || $data['code'] == 210) {
                    //Create new transaction
                    $trans = new Transaction();
                    $trans->setScenario(Transaction::SCENARIO_CREATE);
                    $trans->user_id = $order->user_id;
                    $trans->amount = $data['amount'] / 100;
                    $trans->currency = $data['currency'];
                    $trans->type = Transaction::TYPE_OUTGOING;

                    $trans->addTransactionData('product', $order->product->description);
                    $trans->addTransactionData('limit', $order->product->limit);
                    $trans->addTransactionData('period', $order->product->days);
                    $trans->addTransactionData('order_id', $order->id);

                    if (!$trans->save()) {
                        Yii::error("Failed to save transaction. Response from curopayments is {$dataString}");
                    }
                }

                //Update order status
                $order->setScenario(Order::SCENARIO_UPDATE);
                $order->notification_data = serialize($data);

                switch ($data['code']) {
                    case 200:
                    case 210:
                        $order->status = Order::STATUS_COMPLETED;
                        break;
                    default:
                        $order->status = Order::STATUS_ERROR;
                        break;
                }

                if ($order->save()) {
                    //If order is completed, update user's plan.
                    //Or if order is payment for issued voucher,
                    //mark voucher as "payed"

                    $voucherUpdated = false;
                    $planUpdated = false;

                    if ($order->status == Order::STATUS_COMPLETED) {
                        $voucherId = $order->getOrderData('voucher');

                        if ($voucherId != null) {
                            $voucher = Voucher::findOne($voucherId);

                            if ($voucher != null) {
                                $voucher->setScenario(Voucher::SCENARIO_UPDATE);
                                $voucher->is_payed = 1;

                                $voucherUpdated = $voucher->save();

                                if ($voucherUpdated) {
                                    Yii::$app->mailservice->sendSuccessEmail([
                                        'order_key' => $order->id,
                                        'product' => $order->product->name,
                                        'amount' => $order->cost,
                                        'email' => $order->user->email
                                    ]);
                                } else {
                                    Yii::error("Failed to update voucher status. Voucher id is {$voucherId}. Response from curopayments is {$dataString}");
                                }
                            } else {
                                Yii::error("Voucher {$voucherId} not found. Response from curopayments is {$dataString}");
                            }
                        } else {
                            $planUpdated = ($user->plan == null) ? UserPlan::create($user, $order->product) : $user->plan->applyProduct($order->product);

                            if ($planUpdated) {
                                Yii::$app->mailservice->sendSuccessEmail([
                                    'order_key' => $order->id,
                                    'product' => $order->product->name,
                                    'amount' => $order->cost,
                                    'email' => $order->user->email
                                ]);
                            } else {
                                Yii::error("Failed to update user's plan. Response from curopayments is {$dataString}");
                            }
                        }
                    }

                    if ($order->status != Order::STATUS_COMPLETED || ($planUpdated == false && $voucherUpdated == false)) {
                        //Payment failed or failed to update user's plan or voucher
                        Yii::$app->mailservice->sendFailureEmail([
                            'order_key' => $order->id,
                            'product' => $order->product->name,
                            'amount' => $order->cost,
                            'email' => $order->user->email
                        ]);
                    }
                } else {
                    Yii::error("Failed to update order. Response from curopayments is {$dataString}");
                }
            } else {
                Yii::error("User or order not found. Order id is {$data['reference']}. Response from curopayments is {$dataString}");
            }

            Yii::$app->response->setStatusCode(200);
            return "{$data['transaction']}.{$data['code']}";
        } else {
            Yii::error("Invalid signature. Response from curopayments is {$dataString}");

            Yii::$app->response->setStatusCode(400);
            return;
        }
    }
}
