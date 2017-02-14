<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\ProfileAsset;
use common\models\Product;

ProfileAsset::register($this);

$this->title = $title;

foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}

$lang = explode('-', Yii::$app->language);
$lang = !empty($lang) ? $lang[0] : 'en';

?>
<!-- ADD CREDITS BEGIN -->
<section class="add-credits-content" style="display: block">
    <div class="h4 thin"><?=Yii::t('user_profile', 'Add Credits') ?></div>
    <?php if (isset($checkoutSuccessMessage) && $checkoutSuccessMessage != null): ?>
        <br>
        <div class="alert alert-success"><?= $checkoutSuccessMessage; ?></div>
    <?php elseif (isset($checkoutErrorMessage) && $checkoutErrorMessage != null): ?>
        <br>
        <div class="alert alert-warning"><?= $checkoutErrorMessage; ?></div>
    <?php endif; ?>

    <?php if (!empty($daysProducts)): ?>
    <ul class="subscription-list">
        <div class="b">Time Subscription</div>
        <div class="b xs-show">Unlimited Traffic</div>
        <?php foreach ($daysProducts as $product): ?>
            <?= $this->render('_price', ['type' => Product::TYPE_DAILY, 'product' => $product, 'plan' => $plan]); ?>
        <?php endforeach; ?>
    </ul><br>
    <?php endif; ?>

    <?php if (!empty($limitProducts)): ?>
    <ul class="subscription-list">
        <div class="b">Time Subscription</div>
        <div class="b xs-show">Unlimited Traffic</div>
        <?php foreach ($limitProducts as $product): ?>
            <?= $this->render('_price', ['type' => Product::TYPE_LIMITED, 'product' => $product, 'plan' => $plan]); ?>
        <?php endforeach; ?>
    </ul><br>
    <?php endif; ?>

    <?= $this->render('_voucherForm', ['voucherSuccessMessage' => $voucherSuccessMessage, 'voucherErrorMessage' => $voucherErrorMessage]); ?>
</section>
<!-- ADD CREDITS END -->
