<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\assets\ProfileAsset;
use frontend\assets\FontsAsset;

AppAsset::register($this);
ProfileAsset::register($this);

//Get "my profile" link depending on user's role
if (Yii::$app->user->can('reseller')) {
    $myProfileUrl = '/reseller';
} else {
    $myProfileUrl = '/profile';
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="<?= Yii::$app->charset ?>" http-equiv="Content-Type" content="text/html";>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <header>
        <div class="container">
            <i class="fa fa-bars mobile-menu"></i>
                <span class="logo md-hide"><a href=<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0];
                            ?>><img src="/images/logo.png"/></a></span>
                <nav class="menu sm-hide">
                    <ul>
                    <li class="close-menu md-hide xs-hide"><i class="fa fa-times"></i></li>
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <li class="logo">
                            <a href=<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0];
                            ?>>
                            <img class="logo" src="/images/logo.png"/></a>
                        </li>
                        <li class="link"><?=Html::a(\Yii::t('site', 'My Account'), [$myProfileUrl], $options = [] ) ?></li>
                    <?php endif ?>
                        <li class="link"><?=Html::a(\Yii::t('site', 'How does it works'), ['/work'], $options = [] ) ?></li>
                        <li class="link"><?=Html::a(\Yii::t('site', 'Supported File Hosts'), ['/supported-hosts'], $options = [] ) ?></li>
                        <li class="link"><?=Html::a(\Yii::t('site', 'Uptime & Overview'), ['/uptime'], $options = [] ) ?></li>
                        <li class="link"><?=Html::a(\Yii::t('site', 'Pricing'), ['/price'], $options = [] ) ?></li>
                        <?php if (!Yii::$app->user->isGuest): ?>
                        <li class="md-hide link" ><?=Html::a(\Yii::t('site', 'Log Out'), ['/auth/logout'], $options = [] ) ?></li>
                        <?php endif ?>
                    </ul>
                </nav>
                <nav class="right-menu">
                    <!--coment,because now in life this not used,use local language to english-->
                    <ul>
                        <!-- <li class="language">
                        <div class="dropdown">
                          <div class="en dropdown-toggle" data-toggle="dropdown">
                          <img src="/images/uk_flag.png"/> <i class="fa fa-sort-down"></i>
                          </div>
                           <ul class="dropdown-menu">
                            <li><a href="/user/changelanguage?lang=en&pathInfo=<?=Yii::$app->request->getUrl();?>">EN</a></li><br>
                            <li><a href="/user/changelanguage?lang=ru&pathInfo=<?php echo Yii::$app->request->getUrl(); ?>">RU</a></li>
                          </ul>
                        </div>
                        </li> -->
                        <?php if (Yii::$app->user->isGuest): ?>
                            <li>
                            <?=Html::a(Html::button(\Yii::t('site', 'Log In'), $options = ['class'=>'yellow-btn login weigth_normal'] ), ['/auth/login'], $options = [] ) ?>
                            </li>
                        <?php else: ?>
                            <li class="xs-hide link" ><?=Html::a(\Yii::t('site', 'Log Out'), ['/auth/logout'], $options = [] ) ?>
                        <?php endif ?>
                    </ul>
                </nav>
        </div>
    </header>
        <body class="user-profile">
            <main>
                <section>
                    <div class="container">
                        <aside>
                            <ul class="profile-menu">
                                <li class="clickable download-now <?php if(Yii::$app->controller->action->id=='download'){
                                        echo 'active';
                                    }?>"><a href=<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0]."/download";
                                ?>><?=\Yii::t('user_profile', 'Download Now') ?></a></li>
                                <li class="clickable my-acc <?php if(Yii::$app->controller->action->id=='profile'){
                                        echo 'active';
                                    }?>"><a href=<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0]."/profile";
                                ?>><?=\Yii::t('user_profile', 'My Account') ?></a></li>
                                <li class="clickable add-credits <?php if(Yii::$app->controller->id=='credits'){
                                        echo 'active';
                                    }?>" ><a href=<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0]."/credits";
                                ?>><?=\Yii::t('user_profile', 'Add Credits') ?></a>
                                    </li>
                                <li class="clickable referal <?php if(Yii::$app->controller->id=='referral'){
                                        echo 'active';
                                    }?>"><a href=<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0]."/referral";
                                ?>><?=\Yii::t('user_profile', 'Referal') ?></a></li>
                                <li class="clickable transactions <?php if(Yii::$app->controller->id=='transaction'){
                                        echo 'active';
                                    }?>"><a href=<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0]."/transaction";
                                ?>><?=\Yii::t('user_profile', 'Transactions') ?></a></li>
                                <li class="clickable forum <?php if(Yii::$app->controller->action->id=='forum'){
                                        echo 'active';
                                    }?>"><a href=<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0]."/forum";
                                ?>><?=\Yii::t('user_profile', 'Forum') ?></a></li>
                                <li class="clickable my-downloads <?php if(Yii::$app->controller->action->id=='my-downloads'){
                                        echo 'active';
                                    }?>"><a href=<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0]."/my-downloads";
                                ?>><?=\Yii::t('user_profile', 'My Downloads') ?></a></li>
                                <li class="clickable payment-details <?php if(Yii::$app->controller->action->id=='payment-details'){
                                        echo 'active';
                                    }?>"><a href=<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0]."/payment-details";
                                ?>><?=\Yii::t('user_profile', 'Payment Details') ?></a></li>
                                <li class="clickable overview <?php if(Yii::$app->controller->action->id=='overviews'){
                                        echo 'active';
                                    }?>"><a href=<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0]."/overviews";
                                ?>><?=\Yii::t('user_profile', 'Uptime and Overview') ?></a></li>
                            </ul>
                        </aside>
                        <section class="profile-content">
                            <?= $content ?>
                        </section>
                    </div>
                </section>
            </main>
        </body>
         <footer>
            <div class="container">
                <div><img src="/images/footer_logo.png"/></div>
                <nav class="footer-menu">
                <ul>
                    <li><?=Html::a('How does it works', ['/work'], $options = ['class'=>'link'] ) ?></li>
                    <li><?=Html::a('Supported File Hosts', ['/supported-hosts'], $options = ['class'=>'link'] ) ?></li>
                    <li><?=Html::a('Supported payment methods', ['//supported-payment-methods'], $options = ['class'=>'link'] ) ?></li>
                    <li><?=Html::a('Uptime & Overview', ['/uptime'], $options = ['class'=>'link'] ) ?></li>
                    <li><?=Html::a('Pricing', ['/price'], $options = ['class'=>'link'] ) ?></li>
                    <li><?=Html::a('About Us', ['/about'], $options = ['class'=>'link'] ) ?></li>
                    <li><?=Html::a('Contact', ['/contact'], $options = ['class'=>'link'] ) ?></li>
                    <li><?=Html::a('Terms Of Use', ['/terms'], $options = ['class'=>'link'] ) ?></li>
                    <li><?=Html::a('DMCA', ['/dmca'], $options = ['class'=>'link'] ) ?></li>
                    <li><?=Html::a('Refund Policy', ['/refund-policy'], $options = ['class'=>'link'] ) ?></li>
                    <li><?=Html::a('Privacy Policy', ['/privacy-policy'], $options = ['class'=>'link'] ) ?></li>
                </ul>
            </nav>
            </div>
        </footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
