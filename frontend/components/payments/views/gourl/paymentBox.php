<?php

use frontend\components\payments\assets\gourl\GourlAsset;

GourlAsset::register($this);

?>
<?= $this->beginPage(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='Expires' content='-1'>
        <title>Order checkout</title>
        <?= $this->head(); ?>
    </head>
    <body>
        <?= $this->beginBody(); ?>
        <?= $cryptobox->display_cryptobox() ?>
        <?= $this->endBody(); ?>
    </body>
</html>
<?= $this->endPage(); ?>
