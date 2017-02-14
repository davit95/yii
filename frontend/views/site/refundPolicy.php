<?php
	use yii\helpers\Html;
    foreach ($meta as $key) {
        $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
    }
    $this->title = $title;
?>
<main class="static-page">
	<section class="contact-us white">
		<div class="container">
            <h2 class="weigth_normal">
                <?= Yii::t('dmca',"Refund Policy")?>
            </h2>
            <p class="weigth_normal">
                <?= Yii::t('dmca',"Here in Premium Link Generator, we aim to make sure that our members are satisfied with our services.We are confident that everyone will like our downloading service because it is simple and user-friendly. Moreover, we are willing to put our credibility on the line by offering a risk-free money-back guarantee.In the event that you are not satisfied with your Premium account, you can ask for a refund in the first 2 days and if you haven't downloaded more than 8GB or more than 10 different files. However, there are some cases that a customer is not qualified for a refund due to restrictions. In case you are not aware of these limitations, please check them here {privacy_link}.In your request, you simply need to state the reason why you are not satisfied with our service and the reason for wanting to end your membership. This is very important to us and we take it seriously because we use customers feedbacks to continuously develop our services.For your questions and queries about the refund and cancellation of your membership, do not hesitate to send your e-mail to {support}",['support'=>HTML::a('support@premiumlinkgenerator.com','mailto:support@premiumlinkgenerator.com',['style'=>'color:blue']),'privacy_link'=>HTML::a('privacy-policy','/privacy-policy',['style'=>'color:blue','target'=>'_blank'])]) ?>
            </p>
		</div>
	</section>
</main>