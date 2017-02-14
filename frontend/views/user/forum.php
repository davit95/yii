<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\captcha\Captcha;

	$this->title = $title;

	foreach ($meta as $key) {
	    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
	}
?>
<!-- FORUM BEGIN -->
<section class="forum-content" style="display: block">
	<div class="h4 thin"><?=Yii::t('user_profile', 'Forum') ?></div>
</section>
<!-- FORUM END -->