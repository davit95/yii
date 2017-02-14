<?php

use yii\helpers\Url;

?>
<form class="curopayments-order-form order-form" action="<?= $submitUrl ?>" method="POST">
    <input type="hidden" name="site_id" value="<?= $siteId ?>">
    <input type="hidden" name="pt" value="<?= $paymentMethod ?>">
    <input type="hidden" name="currency_id" value="<?= $order->currency ?>">
    <input type="hidden" name="amount" value="<?= $order->cost * 100 ?>">
    <input type="hidden" name="description" value="<?= $order->description ?>">
    <input type="hidden" name="reference" value="<?= $order->id ?>">
    <input type="hidden" name="hash" value="<?= $hash ?>">
</form>
