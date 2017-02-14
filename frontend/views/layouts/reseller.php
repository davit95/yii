<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\assets\ProfileAsset;

AppAsset::register($this);
ProfileAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
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
            <span class="logo md-hide">
                <a href="<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0];?>">
                    <img src="/images/logo.png"/>
                </a>
            </span>
            <nav class="menu sm-hide">
                <ul>
                <li class="close-menu md-hide xs-hide"><i class="fa fa-times"></i></li>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <li class="logo">
                        <a href=<?php $url_lang = explode('-', Yii::$app->language);echo "/".$url_lang[0];?>>
                            <img class="logo" src="/images/logo.png"/>
                        </a>
                    </li>
                    <li class="link"><?=Html::a(\Yii::t('site', 'My Account'), ['/reseller'], $options = [] ) ?></li>
                <?php endif ?>
                    <li class="link"><?=Html::a(\Yii::t('site', 'How does it works'), ['/work'], $options = [] ) ?></li>
                    <li class="link"><?=Html::a(\Yii::t('site', 'Supported File Hosts'), ['/'], $options = [] ) ?></li>
                    <li class="link"><?=Html::a(\Yii::t('site', 'Uptime & Overview'), ['/uptime'], $options = [] ) ?></li>
                    <li class="link"><?=Html::a(\Yii::t('site', 'Pricing'), ['/price'], $options = [] ) ?></li>
                    <?php if (!Yii::$app->user->isGuest): ?>
                    <li class="md-hide link" ><?=Html::a(\Yii::t('site', 'Log Out'), ['/auth/logout'], $options = [] ) ?></li>
                    <?php endif ?>
                </ul>
            </nav>
            <nav class="right-menu">
                <ul>
                    <?php if (Yii::$app->user->isGuest): ?>
                        <li>
                        <?=Html::a(Html::button(\Yii::t('site', 'Log In'), $options = ['class'=>'yellow-btn login thin'] ), ['/auth/login'], $options = [] ) ?>
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
                                <li class="clickable my-acc <?= (Yii::$app->controller->action->id == 'my-account') ? 'active' : ''?>">
                                    <a href=<?php $url_lang = explode('-', Yii::$app->language); echo "/".$url_lang[0]."/reseller"; ?>><?= \Yii::t('reseller_profile', 'My account'); ?></a>
                                </li>
                                <li class="clickable download-now <?= (Yii::$app->controller->action->id == 'vouchers') ? 'active' : ''?>">
                                    <a href=<?php $url_lang = explode('-', Yii::$app->language); echo "/".$url_lang[0]."/reseller/vouchers"; ?>><?= \Yii::t('reseller_profile', 'Vouchers'); ?></a>
                                </li>
                                <li class="clickable download-now <?= (Yii::$app->controller->action->id == 'products') ? 'active' : ''?>">
                                    <a href=<?php $url_lang = explode('-', Yii::$app->language); echo "/".$url_lang[0]."/reseller/products"; ?>><?= \Yii::t('reseller_profile', 'Products'); ?></a>
                                </li>
                                <li class="clickable download-now <?= (Yii::$app->controller->action->id == 'issue-voucher') ? 'active' : ''?>">
                                    <a href=<?php $url_lang = explode('-', Yii::$app->language); echo "/".$url_lang[0]."/reseller/issue-voucher"; ?>><?= \Yii::t('reseller_profile', 'Issue voucher'); ?></a>
                                </li>
                                <li class="clickable add-credits <?= (Yii::$app->controller->action->id == 'pay-vouchers') ? 'active' : ''?>">
                                    <a href=<?php $url_lang = explode('-', Yii::$app->language); echo "/".$url_lang[0]."/reseller/pay-vouchers"; ?>><?= \Yii::t('reseller_profile', 'Pay voucher'); ?></a>
                                </li>
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
                    <li><?=Html::a('Supported File Hosts', ['/'], $options = ['class'=>'link'] ) ?></li>
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
