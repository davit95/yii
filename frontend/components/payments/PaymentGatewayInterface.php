<?php

namespace frontend\components\payments;

use common\models\Order;

/**
 * Payment gateway interface
 *
 * This interface should be implemented by all
 * payment gateway classes.
 */
interface PaymentGatewayInterface
{
    /**
     * List of actions which will be added to OrderController
     *
     * @return array
     */
    public static function actions();

    /**
     * Renders payment form
     *
     * @param Order $order Order data
     * @param string $paymentMethod payment method id
     * @return mixed
     */
    public function renderOrderForm(Order $order, $paymentMethod);
}
