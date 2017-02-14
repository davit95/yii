<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Voucher;

$this->title = $title;

foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}

?>
<!-- PAY VOUCHER -->
<section class="voucher-content" style="display: block">
	<div class="h4 thin"><?=Yii::t('reseller', 'Pay voucher') ?></div>
	<div class="voucher-details">
		<ul class="lh2">
			<li class="row">
				<div class="col-md-3 b col-sm-4">Voucher code:</div>
				<div class="col-md-9 thin col-sm-8">
                    <?= $voucher->voucher ?> (<a class="copy-to-clipboard js-copy-to-clipboard" href="javascript:void(0)" data-clipboard-text="<?= $voucher->voucher ?>">copy</a>)
				</div>
			</li>
			<li class="row">
				<div class="col-md-3 b col-sm-4">Issued by:</div>
				<div class="col-md-9 thin col-sm-8">
                    <?= $voucher->issuer->email ?>
				</div>
			</li>
			<li class="row">
				<div class="col-md-3 b col-sm-4">Issued on:</div>
				<div class="col-md-9 thin col-sm-8">
                    <?= Yii::$app->formatter->asDate($voucher->created, 'php:d M Y') ?>
                </div>
			</li>
            <li class="row">
				<div class="col-md-3 b col-sm-4">Product name:</div>
				<div class="col-md-9 thin col-sm-8">
                    <?= $voucher->product->name ?>
                </div>
			</li>
            <li class="row">
				<div class="col-md-3 b col-sm-4">Product description:</div>
				<div class="col-md-9 thin col-sm-8">
                    <?= $voucher->product->description ?>
                </div>
			</li>
            <li class="row">
				<div class="col-md-3 b col-sm-4">Product price:</div>
				<div class="col-md-9 thin col-sm-8">
                    <?= $voucher->product->price.' '.$voucher->product->price_currency ?>
				</div>
			</li>
            <li class="row">
				<div class="col-md-3 b col-sm-4">Product price (your's):</div>
				<div class="col-md-9 thin col-sm-8">
                    <?= (($fee != null ) ? $fee->applyDiscount($voucher->product->price) : $voucher->product->price).' '.$voucher->product->price_currency ?>
				</div>
			</li>
            <li class="row">
				<div class="col-md-3 b col-sm-4">Payed:</div>
				<div class="col-md-9 thin col-sm-8">
                    <?= ($voucher->is_payed == 1) ? 'Yes' : 'No'; ?>
                </div>
			</li>
			<li class="row">
				<div class="col-md-3 b col-sm-4">Voucher status:</div>
				<div class="col-md-9 thin col-sm-8">
                    <?= $voucher->status ?>
				</div>
			</li>
			<li class="row">
				<div class="col-md-3 b col-sm-4">Used on:</div>
				<div class="col-md-9 thin col-sm-8">
                    <?= ($voucher->used != null) ? Yii::$app->formatter->asDate($voucher->used, 'php:d M Y') : '-'; ?>
                </div>
			</li>
		</ul><br>

        <a class="btn yellow-btn mozila_button" href="<?= Url::to(['@reseller_pay_vouchers']) ?>">Back</a>
        <a class="btn yellow-btn mozila_button" href="<?= Url::to(['@order_create_for_voucher', 'id' => $voucher->id]) ?>">Pay</a>
    </div>
</section>
<!-- PAY VOUCHER END -->
