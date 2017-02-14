<?php

use yii\helpers\Url;

$this->params['bodyClass'] = 'about-us-page';
$this->title = 'About us';
foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}
$this->title = $title;
?>
<main class="ta-center">
    <section class="about-us">
        <div class="container">
            <h1 class="lthin tx-white"><?= Yii::t('about_us',"About us")?></h1>
            <h6 class='x-lblue' style="color:#fab500"><?= Yii::t('about_us',"It all started from our wild imagination...")?></h6><div class='tx-white thin'><?= Yii::t('about_us',"We acknowledged that the clouds are the future, but saw much more potential in them. When everybody was just storing files in their online drives, synching them with their mobiles and sharing them with others, we imagined something that would push this cloud experience to a whole other Level. Something like a 'Genius Servant' that would work for you: interconnect all your clouds so you would have endless storage space and one window simplicity!")?></div>
            <div class="tx-white"></div>
        </div>
    </section>
    <section class="our-staff white">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="img"><img src="<?= Url::to('@web/images/thumbs_up.png') ?>"/></div>
                    <h5 class=''><?= Yii::t('about_us_vision',"Our vision")?></h5>
                    <div class='thin'><?= Yii::t('about_us',"Was to change the way people work, store and download! We basically wanted to create a service that is user friendly, inexpensive and smart. In other words: we tried to reinvent, redefine and upgrade the whole experience you, the user, have with clouds. We wanted to give the user the Benefit of Simplicity: to access all their clouds with one Account!")?></div>
                </div>
                <div class="col-md-6">
                    <div class="img"><img src="<?= Url::to('@web/images/our_staff.png') ?>"/></div>
                    <h5 class=''><?= Yii::t('about_us',"Our staff")?></h5>
                    <div class='thin'><?= Yii::t('about_us',"as a very committed group of highly qualified specialists in the field of programming, web-design and marketing. All of them share the same values of building advanced software that will make people lives easier. Our main principle is simply to create great software, satisfying the needs of the Internet users.")?></div>
                </div>
            </div>
        </div>
    </section>

    <section class="call-to-action gray">
        <div class="container">
            <h5 class="b"> <?= Yii::t('about_us',"Still have a question? Feel free to contact us!")?></h5>
            <a href="<?= Url::to(['user/contact']) ?>"> <button class="big-button yellow-btn"><?=Yii::t('about_us',"Contact Us") ?></button> </a>
        </div>
    </section>
</main>