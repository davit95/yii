<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\captcha\Captcha;

	$this->title = 'Change Password';
?>
<?php $form = ActiveForm::begin(['class' => 'change-password-form row']); ?>
	<div class="col-md-8">
		<div class="h4 thin title custom-change">Change password</div>

		<div class="input">
			<?= $form->field($model,'oldpass')->input('password')->label() ?>
		</div>

		<div class="input">
	        <?= $form->field($model,'newpass')->input('password')->label() ?>
		</div>

		<div class="input">
		 	<?= $form->field($model,'repeatnewpass')->input('password')->label('Confirm New Password') ?>
		</div>

		<br>
		<?= Html::a('Back', ['/profile'], ['class'=>'btn yellow-btn mozila_button cst_class']) ?>
		<span class="err_mess"> </span>
		<?= Html::submitButton('Save Password', ['class' => 'yellow-btn mozila_button']) ?>
		<span class="err_mess"> </span>
	</div>
<?php ActiveForm::end() ?>