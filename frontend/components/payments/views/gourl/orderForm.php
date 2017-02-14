<?php

use yii\helpers\Url;

?>
<form class="gourl-order-form order-form" action="<?= $submitUrl ?>" method="GET">
    <input type="hidden" name="orderId" value="<?= $order->id ?>">
</form>
