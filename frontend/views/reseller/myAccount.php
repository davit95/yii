<?php

$user = Yii::$app->user->identity;

$this->title = $title;

foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}

?>
<!-- MY ACCOUNT -->
<section class="my-account-content" style="display: block">
	<div class="h4 thin"><?=Yii::t('reseller_profile', 'My Account') ?></div>
	<div class="account-details">
		<ul class="lh2">
			<li class="row">
				<div class="col-md-3 b col-sm-4">Login:</div>
				<div class="col-md-9 thin col-sm-8">
                    <?= $user->email ?>
				</div>
			</li>
            <li class="row">
				<div class="col-md-3 b col-sm-4">Name:</div>
				<div class="col-md-9 thin col-sm-8">
                    <?= $user->getFullName() ?>
				</div>
			</li>
            <li class="row">
				<div class="col-md-3 b col-sm-4">Unpayed vouchers limit:</div>
				<div class="col-md-9 thin col-sm-8">
                    <?= ($vouchersLimit != null) ? $vouchersLimit : 'NA' ?>
				</div>
			</li>
		</ul><br>
        <a href="/change-password" class="btn yellow-btn change-button mozila_button">Change Password</a>

</section>
<!-- MY ACCOUNT END -->
