<?php

use yii\helpers\Url;

$sign = md5("{$apiKey}|{$pmId}|{$order->cost}|{$order->currency}|{$order->id}|$apiSecret");

?>
<form class="payssion-order-form order-form" action="<?= $submitUrl ?>" method="POST">
    <input type="hidden" name="api_key" value="<?= $apiKey ?>">
    <input type="hidden" name="api_sig" value="<?= $sign ?>">
    <input type="hidden" name="pm_id" value="<?= $pmId ?>">
    <input type="hidden" name="order_id" value="<?= $order->id ?>">
    <input type="hidden" name="description" value="<?= $order->description ?>">
    <input type="hidden" name="amount" value="<?= $order->cost ?>">
    <input type="hidden" name="currency" value="<?= $order->currency ?>">
    <input type="hidden" name="return_url" value="<?= $returnUrl ?>">
</form>
