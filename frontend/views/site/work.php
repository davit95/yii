<?php

    use yii\helpers\Url;
    use yii\helpers\Html;

    $this->params['bodyClass'] = 'how-it-works-page';
    $this->title = 'How it works';
    foreach ($meta as $key) {
        $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
    }
    $this->title = $title;
?>
<main class="ta-center">
    <section class="how-it-works">
        <div class="container">
            <h1 class="lthin tx-white"><?= Yii::t('how_it_works',"How it works") ?></h1>
            <h5 class='tx-lblue'><?= Yii::t('how_it_works',"You will never have to experience any delays with your downloads. Furthermore, you don’t need to wait for the files to finish downloading in our servers then transfer it to your device. Simply add the link from any supported file host then the files will be immediately downloaded. ") ?></h5>
            <div class="img xs-hide"><img  class="sm-fw" src="<?= Url::to('@web/images/how_it_works1.png') ?>"/></div>
                <div id="howItWorksCarousel" class="carousel slide" data-ride="carousel">
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                    <div class="item active ta-center">
                         <img src="<?= Url::to('@web/images/img3.png') ?>"/>
                         <h5 class="tx-blue">
                            Paste links
                            <div class="thin">Inside the box</div>
                        </h5>
                    </div>
                    <div class="item ta-center">
                         <img src="<?= Url::to('@web/images/img3.png') ?>"/>
                         <h5 class="tx-blue">
                            Paste links
                            <div class="thin">Inside the box</div>
                        </h5>
                    </div>
                  <!-- Left and right controls -->
                  <a class="left carousel-control" href="#howItWorksCarousel" role="button" data-slide="prev">
                    <img src="/images/arrow_left_white.png"/>
                  </a>
                  <a class="right carousel-control" href="#howItWorksCarousel" role="button" data-slide="next">
                    <img src="/images/arrow_right_white.png"/>
                  </a>
                </div>
            </div>
        </div>
    </section>
    <section class="join-now white">
        <div class="container">
            <div class="col-md-4 col-sm-4 xs-hide">
                <h5 class="tx-blue">
                <?= Yii::t('how_it_works',"Paste links {div}",['div'=>Html::tag('div',Yii::t('how_it_works',"Inside the box"),['class'=>"thin"])]) ?>
                </h5>
            </div>
            <div class="col-md-4 col-sm-4 xs-hide">
                <h5 class="tx-blue">
                    <?= Yii::t('how_it_works',"{div} Generate PLG Link",['div'=>Html::tag('div',Yii::t('how_it_works',"Press the"),['class'=>"thin"])]) ?>
                </h5>
            </div>
            <div class="col-md-4 col-sm-4 xs-hide">
                <h5 class="tx-blue">
                    <?= Yii::t('how_it_works',"Download the file {tag} {span} copy it into your {tag} download accelerator",['span'=>Html::tag('span',Yii::t('how_it_works',"or"),['class'=>"thin"]),'tag'=>Html::tag('br')]) ?>
                </h5>
            </div>
            <?php if (Yii::$app->user->isGuest): ?>
            <a href="<?= Url::to(['/auth/register']) ?>"> <button class="big-button yellow-btn join-now-btn"><?= Yii::t('how_it_works',"Join now") ?></button> </a>
            <?php endif; ?>

        </div>
    </section>
    <section class="call-to-action gray">
        <div class="container">
           <h5 class='b'><?= Yii::t('how_it_works',"We want to make your life as easy as possible, which is why we partnered with the top Download Managers.") ?></h5>
           <div class='weigth_normal'><?= Yii::t('how_it_works',"By using the Download Managers you find below, You’ll never have to worry about interruptions and getting your files via premium link generator becomes significantly faster and simpler. Take your pick from the highly customizable apps and marvel as you download files at blazing speeds with a tap of a button.") ?><br>
                <?= Yii::t('how_it_works',"Take your pick from the highly customizable apps and marvel as you download files at blazing speeds with a tap of a button.") ?>
           </div>
        </div>
    </section>

    <section class="blue-gradient">
        <div class="container">
            <div class="col-md-6"><img class="img-responsive " src="<?= Url::to('@web/images/how_it_works2.png') ?>"/></div>
            <div class="col-md-5 ta-left">
                <h5 class="tx-white">JetDownloader</h5>
                <div class="tx-lblue lh">
                   <?= Yii::t('how_it_works',"Download files from several file hosters while managing your bandwidth with the help of Jet Downloader. First, you need to organize your file hosting account in the software, and then you can start downloading any file. It supports multi-segments download, which means that you can download fractions of one file at the same time then merge them. Furthermore, your download speed will be better without any interruptions.") ?>
                </div>
            </div>
        </div>
    </section>

    <section class="white text-image-section">
        <div class="container">

            <div class="col-md-5 ta-left">
                <h5 class="tx-blue">JDownloader</h5>
                <div class="lh2">
                    <?= Yii::t('how_it_works',"JDownloader is a free, open-source download management tool. Due to its large group of developers, downloading files using it is simple and fast. In addition, it has several features that users can use including start, stop, and pause options when downloading; setting bandwidth limitations; auto-extract archives; and much more. This tool can definitely help you save time every day!") ?>
                </div>
            </div>
            <div class="col-md-6"><img class="img-responsive" src="<?= Url::to('@web/images/how_it_works3.png') ?>"/></div>
        </div>
    </section>

    <?php if (Yii::$app->user->isGuest): ?>
    <section class="call-to-action">
        <div class="container">
            <h4 class="thin">
             <?= Yii::t('how_it_works',"Download everything in {host_number} file hosts using one account when you join today.",['tag'=>HTML::tag('br'),'host_number'=>$hostsNum]) ?></h4>
            <a href="<?= Url::to(['/auth/register']) ?>"> <button class="big-button yellow-btn"> <?= Yii::t('how_it_works',"Create Account") ?></button> </a>
        </div>
    </section>
    <?php endif; ?>

</main>