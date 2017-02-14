<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\bootstrap\ActiveForm;
use frontend\assets\FontsAsset;

AppAsset::register($this);

$this->params['bodyClass'] = isset($this->params['bodyClass']) ? $this->params['bodyClass'] : 'home-page';

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
    <meta charset="<?= Yii::$app->charset ?>" http-equiv="Content-Type" content="text/html";>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="<?= $this->params['bodyClass'] ?>">
<?php $this->beginBody() ?>
    <header>
        <div class="container">
                <i class="fa fa-bars mobile-menu"></i>
                <span class="logo md-hide"><a href=<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0];?>>
                <img src="/images/logo.png"/></a></span>
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
                    <?php else: ?>
                        <li class="logo"><a href=<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0];
                            ?>> <img src="/images/logo.png"/></a></li>
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
                            <li class="xs-hide link"><?=Html::a(\Yii::t('site', 'Log Out'), ['/auth/logout'], $options = [] ) ?></li>
                        <?php endif ?>
                    </ul>
                </nav>
        </div>
    </header>
        <?= $content ?>
        </div>
        <footer>
            <div class="container">
                <div><img src="/images/footer_logo.png"/></div>
                <nav class="footer-menu">
                <ul>
                    <li><?=Html::a('How does it works', ['/work'], $options = ['class'=>'link'] ) ?></li>
                    <li><?=Html::a('Supported File Hosts', ['/supported-hosts'], $options = ['class'=>'link'] ) ?></li>
                    <li><?=Html::a('Supported payment methods', ['/supported-payment-methods'], $options = ['class'=>'link'] ) ?></li>
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
