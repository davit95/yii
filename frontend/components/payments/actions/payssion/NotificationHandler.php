<?php

namespace frontend\components\payments\actions\payssion;

use Yii;
use yii\base\Action;
use common\models\Order;
use common\models\UserPlan;
use common\models\Transaction;
use common\models\Voucher;
use frontend\components\payments\PayssionPaymentGateway;

class NotificationHandler extends Action
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        //Discable csrf validation
        Yii::$app->request->enableCsrfValidation = false;
    }

    /**
     * Handles notification request from payssion
     *
     * @return mixed
     */
    public function run()
    {
        $payssionGateway = new PayssionPaymentGateway();

        $data = Yii::$app->request->post();
        $dataString = print_r($data, true);

        if ($payssionGateway->isValidResponse($data)) {

            $order = Order::findOne($data['order_id']);

            $user = $order->user;

            if ($order != null) {
                if ($data['state'] == 'completed' || $data['state'] == 'paid_partial') {
                    //Create new transaction
                    $trans = new Transaction();
                    $trans->setScenario(Transaction::SCENARIO_CREATE);
                    $trans->user_id = $order->user_id;
                    $trans->amount = $data['amount'];
                    $trans->currency = $data['currency'];;
                    $trans->type = Transaction::TYPE_OUTGOING;

                    $trans->addTransactionData('product', $order->product->description);
                    $trans->addTransactionData('limit', $order->product->limit);
                    $trans->addTransactionData('period', $order->product->days);
                    $trans->addTransactionData('order_id', $order->id);

                    if (!$trans->save()) {
                        Yii::error("Failed to save transaction. Response from payssion is {$dataString}");
                    }
                }

                //Update order status
                $order->setScenario(Order::SCENARIO_UPDATE);
                $order->notification_data = serialize($data);

                switch ($data['state']) {
                    case 'completed':
                        $order->status = Order::STATUS_COMPLETED;
                        break;
                    case 'paid_partial':
                        $order->status = Order::STATUS_PAUSED;
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
                    Yii::error("Failed to update order. Response from payssion is {$dataString}");
                }
            } else {
                $dataString = print_r($data, true);
                Yii::error("User or order not found. User id is {$data['user']}. Order id is {$data['user']}. Response from payssion is {$dataString}");

                Yii::$app->response->setStatusCode(400);
                return;
            }
        } else {
            Yii::error("Invalid signature. Response from payssion is {$dataString}");

            Yii::$app->response->setStatusCode(400);
            return;
        }

        Yii::$app->response->setStatusCode(200);
        return;
    }
}
