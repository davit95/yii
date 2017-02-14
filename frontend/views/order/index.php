<?php

use yii\helpers\Url;
use frontend\assets\OrderAsset;

OrderAsset::register($this);

$this->title = $title;

foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}

?>
<main>
    <section class="order-checkout">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="thin">Order checkout</h2>
                </div>
            </div>
            <div class="row checkout-form-wrapper">
                <div class="input cf">
                    <div class="col-md-4">
                        <label class="thin">Payment method: </label>
                    </div>
                    <div class="col-md-8">
                        <select class="js-payment-method-select">
                            <option value="">Please select payment method</option>
                            <?php foreach ($paymentMethods as $id => $paymentMethod):?>
                                <option value="<?= Url::to(['@order_render_form', 'orderId' => $order->id, 'pmId' => $id]) ?>" ><?= $paymentMethod['label'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="input cf">
                    <div class="col-md-4">
                        <label class="thin">Description: </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" disabled="disabled" value="<?= $order->description ?>"/>
                    </div>
                </div>
                <div class="input cf">
                    <div class="col-md-4">
                        <label class="thin">Amount: </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" disabled="disabled" value="<?= $order->cost.$order->currency ?>"/>
                    </div>
                </div>
                <div class="btn-container col-md-12">
                    <a class = "btn yellow-btn uppercase mozila_button" href="<?= Url::previous(); ?>">Cancel</a>
                    <button type="button" class="yellow-btn uppercase disabled js-submit-order-form" disabled="disabled">Checkout</button>
                </div>
            </div>
        </div>
    </section>
</main>
