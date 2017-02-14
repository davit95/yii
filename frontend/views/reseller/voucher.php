<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Voucher;

$this->title = $title;

foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}

?>
<!-- VOUCHER -->
<section class="voucher-content" style="display: block">
	<div class="h4 thin"><?=Yii::t('reseller', 'Voucher') ?></div>
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
        <a class="btn yellow-btn mozila_button" href="<?= Url::to(['@reseller_vouchers']) ?>">Back</a>
        <?php if ($voucher->status == Voucher::STATUS_NOT_USED): ?>
            <form id="voucher-suspend-form" action="<?= Url::to(['@reseller_suspend_voucher']) ?>" method="POST">
                <input type="hidden" name="id" value="<?= $voucher->id ?>" />
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>" />
                <button type="submit" class="yellow-btn">Suspend</button>
            </form>
        <?php endif; ?>
    </div>
</section>
<!-- VOUCHER END -->
