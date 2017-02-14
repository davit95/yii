<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\captcha\Captcha;
	
	$this->title = $title;
	
	foreach ($meta as $key) {
        $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
    }
?>
	<section class="my-account-content" style="display: block">
		<div class="h4 thin">My Account</div>
		<div class="account-details">
			<ul class="lh2">
				<li class="row">
					<div class="col-md-3 b col-sm-4">Login:</div>
					<div class="col-md-9 thin col-sm-8">
					<?php if (null!=Yii::$app->user->identity) {
						echo Yii::$app->user->identity->email;
						}
					?>
					</div>
				</li>
				<li class="row">
					<div class="col-md-3 b col-sm-4">Expiration date:</div>
					<div class="col-md-9 thin col-sm-8">
						<?php if (null!=Yii::$app->user->identity) {
							echo Yii::$app->user->identity->expiration_date;
						}
						?>
					</div>
				</li>
				<li class="row">
					<div class="col-md-3 b col-sm-4">Extra Traffic left:</div>
					<div class="col-md-9 thin col-sm-8">UNLIMITED</div>
				</li>
				<li class="row">
					<div class="col-md-3 b col-sm-4">Last Download:</div>
					<div class="col-md-9 thin col-sm-8">
						<?php if (null!=Yii::$app->user->identity) {
							echo $last_download;
						}
						?>
					</div>
				</li>
				<li class="row">
					<div class="col-md-3 b col-sm-4">Your Referal Voucher:</div>
					<div class="col-md-9 thin col-sm-8">N1ZZO-OiXP-080l-z74h-2Ty</div>
				</li>
			</ul><br>
			<button class="yellow-btn">Upgrade Account</button> <span class="err_mess"> </span>
			<button class="yellow-btn change-button"><a href="/<?=$lang1?>/site/change-password">Change Password</a></button> <span class="err_mess"> </span>
	</section>
<!-- MY ACCOUNT END -->