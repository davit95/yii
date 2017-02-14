<?php

use yii\helpers\Url;

?>
<div class="b">Use a Voucher</div>
<div class="thin">If you bought an PremiumLinkGenerator voucher at one of our resellers, simply enter the code here to credit your account.</div>
<?php if (isset($voucherSuccessMessage) && $voucherSuccessMessage != null): ?>
    <br>
    <div class="alert alert-success"><?= $voucherSuccessMessage; ?></div>
<?php elseif (isset($voucherErrorMessage) && $voucherErrorMessage != null): ?>
    <br>
    <div class="alert alert-warning"><?= $voucherErrorMessage; ?></div>
<?php endif; ?>

<form id="voucher" class="vaucher-form" method="POST" action="<?= Url::to('@profile_proc_voucher'); ?>">
    <div class="input">
        <input type="text" class="ta-center" name="voucher" placeholder="Enter your voucher code here"/>
    </div>
    <div class="image input">
    <div class="image g-recaptcha" data-sitekey="<?= Yii::$app->config->get('GoogleReCaptcha.PublicKey') ?>"></div>
    </div>
    <input type="hidden" name="user_id" value="<?= Yii::$app->user->identity->id; ?>"/>
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken(); ?>"/>
    <button type="submit" class="yellow-btn uppercase full-width">Confirm this voucher</button>
</form>
