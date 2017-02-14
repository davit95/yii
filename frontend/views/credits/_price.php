<?php
use yii\helpers\Html;

use common\models\Product;

if (!function_exists('formatPrice')) {
    function formatPrice ($amount) {
        $amount = round($amount, 2);
        $intAmount = floor($amount);
        $frcAmount = round(($amount - $intAmount) * 100);

        return "$intAmount <sup>$frcAmount</sup>";
    }
}

$lang = explode('-', Yii::$app->language);
$lang = !empty($lang) ? $lang[0] : 'en';

?>
<li class="cf">
    <div class="col-md-3 col-sm-3 col-xs-4">
        <?php if ($type == Product::TYPE_DAILY): ?>
            <div class="period h5 uppercase tx-blue"><?= $product->days ?><span class="lthin"> Days</span></div>
        <?php else: ?>
            <div class="period h5 uppercase tx-blue"><?= $product->limit ?><span class="lthin"> Gb</span></div>
        <?php endif; ?>
    </div>
    <div class="col-md-3 ta-center col-sm-4 xs-hide">
        <?php if ($type == Product::TYPE_DAILY): ?>
            <div class="liter"><img src="/images/infinity.png"> Unlimited Traffic</div>
        <?php else: ?>
            <div class="liter"><?= $product->limit ?><span class="lthin"> Gb</span></div>
        <?php endif; ?>
    </div>
    <div class="col-md-3 ta-center col-sm-2 col-xs-3">
        <div class="price h5">$<?= formatPrice($product->price) ?></div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-5">
        <?php if ($plan != null): ?>
            <?php if ($type == $plan->product_type): ?>
                <a href="<?= '/'.$lang.'/order/create/product/'.$product->id ?>" class="btn yellow-btn uppercase right mozila_button">Order</a>
            <?php else: ?>
                <a href="javascript:void(0)" class="btn yellow-btn uppercase right mozila_button disabled">Order</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="<?= '/'.$lang.'/order/create/product/'.$product->id ?>" class="btn yellow-btn uppercase right mozila_button">Order</a>
        <?php endif; ?>
    </div>
</li>
