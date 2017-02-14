<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\captcha\Captcha;
	use yii\helpers\Url ;
	$this->title = 'Supported Payment Methods';
?>
<!-- PAYMENT DETAILS BEGIN -->
<section class="payment-details-content" style="display: block">
	<div class="h4 thin"><?=Yii::t('user_profile', 'Payment Details') ?></div>

	<div class="thin">Fill out this page if you wish to become an affiliate of <a href="#" class="link tx-blue">Premiumlinkgenerator.com</a>.</div><br>
	<ul class="payment-details-list thin lh">
		<li>• Payment Net 30</li>
		<li>• 30 day cookie time, you will receive 10% commission on all refered customers</li>
		<li>• VAT: If EU Business only</li>
	</ul><br><br>
	<form class="payment-details-form row">
		<div class="col-md-5 thin">

			<div class="input">
				<div>Full name or Business Name </div>
				<input type="text"/>
			</div><br>

			<div class="input">
				<div>VAT Number (If EU Business only)<br></div>
				<input type="text"/>
			</div><br>

			<div class="input">
				<div>E-mail address </div>
				<input type="email"/>
			</div><br>

			<div class="input">
				<div>Payment method </div>
				<select>
					<option>Paypal</option>
					<option>VISA</option>
					<option>Mastercard</option>
				</select>
			</div><br>

			<div class="input">
				<div>Paypal ID</div>
				<input type="text"/>
			</div><br>

			<div class="input checkbox">
				<label>
					<input type="checkbox"/>
					<span></span>
					I Accept
					<a href="/affiliate-terms" class="link tx-blue">Affiliate terms and service policy</a>
				</label>
			</div><br>

			<button class="yellow-btn">Save</button> <span class="err_mess"> </span>
		</div>
	</form>

</section>
<!-- PAYMENT DETAILS END -->