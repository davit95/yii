<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Voucher;

$user = Yii::$app->user->identity;

//Check if reseller can issue more vouchers
$unpayedVouchersCount = Voucher::find()
    ->where(['issuer_id' => $user->id])
    ->andWhere(['<>', 'status', Voucher::STATUS_SUSPENDED])
    ->andWhere(['is_payed' => 0])
    ->count();
$canIssue = $vouchersLimit > $unpayedVouchersCount;

$this->title = $title;

foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}

?>
<!-- ISSUE VOUCHER BEGIN -->
<section class="issue-voucher-content" style="display:block">
	<div class="h4 thin"><?=Yii::t('reseller_profile', 'Issue voucher') ?></div>
    <?php if (!$canIssue): ?>
        <div class="alert alert-warning">You have reached limit of <?= $vouchersLimit ?> issed unpayed vouchers.</div>
    <?php endif; ?>
    <?php if (isset($errorMessage) && $errorMessage != null): ?>
        <div class="alert alert-warning"><?= $errorMessage; ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <?php $form = ActiveForm::begin(['options' => ['id' => 'voucher-form']]); ?>
                <div class="input">
                    <div>Issuer:</div>
                    <input type="text" value="<?= $user->email ?>" disabled="disabled"/>
                </div>
                <div class="input">
                    <div>Product:</div>
                    <select name="product_id">
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product->id ?>"><?= $product->description ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input">
                    <div>Status:</div>
                    <input type="text" name="status" value="<?= Voucher::STATUS_NOT_USED ?>" disabled="disabled"/>
                </div>
                </br>
                <div class="ta-left group-btn">
                	<button type="submit" class="yellow-btn <?= (!$canIssue) ? 'disabled' : ''; ?>" <?= (!$canIssue) ? 'disabled' : ''; ?>>Issue voucher</button>&nbsp;&nbsp;&nbsp;
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</section>
<!-- ISSUE VOUCHER END -->
