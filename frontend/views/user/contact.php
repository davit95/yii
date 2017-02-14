<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\ReCaptchaAsset;

ReCaptchaAsset::register($this);

$this->params['bodyClass'] = 'contacts-page';
$this->title = $title;

$reCaptchErrors = $contactForm->getErrors('reCaptchaResp');
foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}
?>
<main class="">
    <section class="contact-us white">
        <div class="container">
                <div class="col-xs-12 col-md-12">
                    <?php if(Yii::$app->session->hasFlash('consol_v_error')): ?>
                        <div class="alert alert-success" role="alert">
                            <?= Yii::$app->session->getFlash('consol_v_error') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <h2 class='thin'>
                        <?= Yii::t('contact_us',"Contact Us") ?>
                    </h2>
                    <h5>
                        <?= Yii::t('contact_us',"Values we stand for") ?>
                    </h5>
                    <div class='b'>
                        <?= Yii::t('contact_us',"Real and secure privacy") ?>
                    </div>
                    <p class='thin'><?= Yii::t('contact_us',"Are you often out, surfing in cafes, railway stations or airports? Thats an invitation for data thieves. Save your networks, your identity, bank and credit card data. All Internet connections are encrypted using up to 256-bit - so no one will get your data.") ?></p><br>
                    <div class='b'> <?= Yii::t('contact_us',"Absolutely reliable") ?></div>
                    <p class='thin'><?= Yii::t('contact_us',"We don know cheapy, just low cost for value! While selecting our infrastructure, we look for the highest quality you can get in our worldwide server - network. Access to all sites is well protected against unauthorized access") ?></p><br>
                    <div class='b'><?= Yii::t('contact_us',"Full cost control") ?></div>
                    <p class='thin'><?= Yii::t('contact_us',"No ongoing subscription, with us you only pay for the product you chose. Risk free and absolutely transparent.") ?></p><br>
                    <div class='b'><?= Yii::t('contact_us',"Address") ?></div>
                    <p class='thin'>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="thin">
                                    <li><i>Visitation address:</i></li>
                                    <li>E-Zone Vredenberg E-Commercepark</li>
                                    <li>Vredenberg Unit B03.3</li>
                                    <li>Willemstad - Curacao - Caribbean</li>
                                    <li>Chamber of Commerce no.: 141044</li>
                                    <li>Owner: Mateo van der Zwet</li>
                                    <li>Email: support@mrpay.io</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="thin">
                                    <li><i>Our officlal company name and address:</i></li>
                                    <li>Cura Beheer B.V.</li>
                                    <li>Kaya W.F.G. (Jombi) Mensing 36</li>
                                    <li>Willemstad - Curaçao</li>
                                    <li>Email: support@mrpay.io</li>
                                    <li>Tel Phone: (+5999) 4338940</li>
                                    <li>Fax: (+5999) 4338941</li>
                                </ul>
                            </div>
                        </div>
                    </p><br>
                    <button onclick="window.location='https://www.facebook.com/premiumlinkgenerator1/';" class="facebook"><i class="fa fa-facebook"></i> Follow us on Facebook</button>
                </div>
                <div class="col-md-6">
                    <?php $form = ActiveForm::begin(['options' => ['id' => 'contact-form', 'class' => 'contact-us-form']]); ?>
                        <div class="col-md-12"><h5><?= Yii::t('contact_us','If you have a question feel free to contact us') ?></h5></div>
                        <div class="input cf">
                            <div class="col-md-4">
                                <label class="thin"><?= Yii::t('contact_us','E-mail address') ?>: </label>
                            </div>
                            <div class="col-md-8">
                                <?= $form->field($contactForm, 'email')->textInput(['class' => '', 'name' => 'email'])->label(false) ?>
                            </div>
                        </div>

                        <div class="input cf">
                            <div class="col-md-4">
                                <label class="thin"><?= Yii::t('contact_us','Subject') ?>: </label>
                            </div>
                            <div class="col-md-8">
                                <?= $form->field($contactForm, 'subject')->textInput(['class' => '', 'name' => 'subject'])->label(false) ?>
                            </div>
                        </div>

                        <div class="input cf">
                            <div class="col-md-4">
                                <label class="thin"><?= Yii::t('contact_us','Message') ?>: </label>
                            </div>
                            <div class="col-md-8">
                                <?= $form->field($contactForm, 'message')->textarea(['class' => '', 'name' => 'message'])->label(false) ?>
                            </div>
                        </div>

                        <div class="input cf">
                            <div class="col-md-4">
                                <label class="thin"><?= Yii::t('contact_us','Antibot') ?>: </label>
                            </div>
                            <div class="col-md-8 <?php if (!empty($reCaptchErrors)): ?>has-error<?php endif; ?>">
                                <div class="image g-recaptcha" data-sitekey="<?= Yii::$app->config->get('GoogleReCaptcha.PublicKey') ?>"></div>
                                <?php if (!empty($reCaptchErrors)): ?>
                                    <div class="help-block"><?= reset($reCaptchErrors) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="input cf">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <button class="yellow-btn thin"><?= Yii::t('contact_us_button','Send') ?></button>&nbsp;
                                <span class="err_mess"></span>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
        </div>
    </section>
</main>
