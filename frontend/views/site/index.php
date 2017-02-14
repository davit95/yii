<?php

use yii\helpers\Url;
use common\models\Host;
use yii\helpers\Html;

$hostsNum = $hosts->count();
$approxHostsNum = $hostsNum - count($popularHosts);
$approxHostsNum = ($approxHostsNum > 10) ? floor($approxHostsNum / 10) * 10 : $approxHostsNum;
$hostsPerSlide = 16;
$index = 1;
$slide = 0;
$slides = array();
foreach ($hosts->each() as $host) {
    if ($index == 1) {
        $slides[$slide] = array();
    }
    $slides[$slide][] = $host;
    if ($index % $hostsPerSlide == 0) {
        $slide++;
        $slides[$slide] = array();
    }
    $index++;
}
foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}
$this->title = $title;
?>
<main class="">
    <section class="banner">
        <div class="container">
            <div class="logo"><img src="<?= Url::to('@web/images/logo.png') ?>"/></div>
            <h1 class="lthin tx-white"><?= Yii::t('homepage',"Download Everything With One Account")?></h1>
            <h4 class="tx-lblue"><?= Yii::t('homepage',"One site. One low price.{tag}{host_number} different file hosts to download from!",['tag'=>HTML::tag('br'),'host_number'=>$hostsNum])?></h4>
            <div class="icon"><img class = "icon_down" src="<?= Url::to('@web/images/mouse00.svg') ?>"/></div>
        </div>
    </section>

    <section class="hosts">
        <div class="container">
            <ul>
                <?php foreach ($popularHosts as $host): ?>
                    <?php 
                        $url = substr($host->logoUrl, 3);
                    ?>
                <li>
                    <!-- <a target = "_blank" href=<?=  $host->host_url ?> > -->
                    <a href=<?= '/'.$lang_path."/hosts/".explode('.',$host->name)[0]?> > 
                        <img class = "hosts-style_homepage" src="/images/color-hosts/<?= $host->logo?>">
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php if ($approxHostsNum > 0): ?>
                <h6 class="uppercase tx-lblack"><?= Yii::t('homepage',"And more than")?>
                    <span class="underline">
                        <a href="/<?=$lang_path?>/supported-hosts"> <?= Yii::t('homepage',"{host_number} another Hosts",['host_number'=>$hostsNum])?>
                    </span></a>
                </h6>
            <?php endif; ?>
        </div>
    </section>

    <section class="why-plg gray">
        <div class="container">
            <h2><?= Yii::t('homepage',"Why Premium Link Generator")?></h2>
            <ul class="row">
                <li class="col-md-4">
                    <div class="img"><img src="<?= Url::to('@web/images/why1.png') ?>"/></div>
                    <h6 class='thin'><?= Yii::t('homepage',"Download from everywhere")?></h6>
                    <h6><?= Yii::t('homepage',"All major hosters supported")?></h6>
                    <p class='weigth_normal'><?= Yii::t('homepage',"Downloading files from Turbobit, Filepost, Extabit, Rapidgator, Uploaded.net and other one-click -hosters? Now you can have them all with one PLG subscription!")?></p>
                </li>

                <li class="col-md-4">
                    <div class="img"><img src="<?= Url::to('@web/images/why2.png') ?>"/></div>
                    <h6 class='thin'><?= Yii::t('homepage',"Download super-fast")?></h6>
                    <h6><?= Yii::t('homepage',"Utilize your max speed")?></h6>
                    <p class='weigth_normal'><?= Yii::t('homepage',"Download any files you want as premium without waiting time, at a very high speed, no matter on which site the files are hosted!")?></p>
                </li>
                <li class="col-md-4">
                    <div class="img"><img src="<?= Url::to('@web/images/why3.png') ?>"/></div>
                    <h6 class='thin'><?= Yii::t('homepage',"Keep your money in your pocket")?></h6>
                    <h6><?= Yii::t('homepage',"1 Account, value of {host_number} FileHosts!",['host_number'=>$hostsNum])?></h6>
                    <p class='weigth_normal'><?= Yii::t('homepage',"Don't spend your money on various one click accounts. Downloading does not need to cost you a fortune anymore. All you need is one PLG account and you are 100% covered.")?></p>
                </li>
            </ul>
        </div>
    </section>

    <section class="super-fast-hosts">
        <div class="container">
            <h2 class='tx-white lthin'>
                <?= Yii::t('homepage',"When It Comes To Servers {tag} We Have The Best That Exist!",['tag'=>Html::tag('br')])?>
            </h2>
            <h4 class="tx-lblue"><?= Yii::t('homepage',"So you can enjoy super-fast downloading {tag} from {host_number} different file hosts.",['tag'=>Html::tag('br'),'host_number'=>$hostsNum])?></h4>

            <div id="hostsCarousel" class="carousel slide" data-ride="carousel">
              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                  <?php foreach ($slides as $index => $slide): ?>
                      <div class="item <?php if ($index == 0): ?>active<?php endif; ?>">
                          <ul class="row">
                              <?php foreach ($slide as $host): ?>
                                <?php 
                                    $url = substr($host->getLogoUrl(Host::LOGO_MONOCHROME), 3);
                                    ?>
                                    <li class="col-md-3">
                                        <a href=<?= '/'.$lang_path."/hosts/".explode('.',$host->name)[0]?> > 
                                            <img class = "hosts-mono" src="<?= $url ?>"/>
                                        </a>
                                    </li>
                              <?php endforeach; ?>
                          </ul>
                      </div>
                  <?php endforeach; ?>
              </div>

              <!-- Left and right controls -->
              <a style = "position: static;" class="left carousel-control" href="#hostsCarousel" role="button" data-slide="prev">
                <img src="<?= Url::to('@web/images/left_arrow.png') ?>"/>
              </a>
              <a style = "position: static;" class="right carousel-control" href="#hostsCarousel" role="button" data-slide="next">
                <img src="<?= Url::to('@web/images/right_arrow.png') ?>"/>
              </a>
            </div>
            <div class="ta-center"><a href="<?= Url::to(['hosts']) ?>"> <button class="transparent-btn"> <?= Yii::t('homepage_button','View All File Hosts') ?></button> </a></div>
        </div>
    </section>

    <section class="easy-to-work">
        <div class="container ta-center">
            <h2><?= Yii::t('homepage',"Works very easy")?></h2>
            <ul class="row">
                <li class="navigation">
                    <div class="previous-item">
                        <img src="/images/arrow_left.png"/>
                    </div>
                    <div class="next-item">
                        <img src="/images/arrow_right.png"/>
                    </div>
                </li>
                <li class="col-md-4 col-sm-3 active">
                    <div class="img"><img src="<?= Url::to('@web/images/works1.png') ?>"/></div>
                    <h6 class="tx-blue">
                        <?= Yii::t('homepage',"Copy Paste your {tag} download link",['tag'=>HTML::tag('br')])?>
                    </h6>
                </li>
                <li class="col-md-4 col-sm-6">
                    <div class="img"><img src="<?= Url::to('@web/images/works2.png') ?>"/></div>
                    <h6 class="tx-blue">
                        <?= Yii::t('homepage',"Let us process the link")?>
                    </h6>
                </li>
                <li class="col-md-4 col-sm-3">
                    <div class="img"><img src="<?= Url::to('@web/images/works3.png') ?>"/></div>
                    <h6 class="tx-blue">
                        <?= Yii::t('homepage',"Download the file {tag} at high speed!",['tag'=>HTML::tag('br')])?>
                    </h6>
                </li>
            </ul>
            <h4 class='tx-lblue'><?= Yii::t('homepage',"That's it! {tag} Enjoy your download!",['tag'=>HTML::tag('br')])?></h4>
        </div>
    </section>
    <?php if (Yii::$app->user->isGuest): ?>
    <section class="call-to-action">
        <div class="container">
            <h4 class="thin"><?=Yii::t('homepage',"Join Today and download EVERYTHING from EVERYWHERE") ?><br><?=Yii::t('homepage','{host_number} File Hosts in one Account',['host_number'=>$hostsNum]) ?></h4>
            <a href="<?= Url::to(['auth/register']) ?>"> <button class="big-button yellow-btn"><?= Yii::t('homepage_create_button',"Create Account")?></button> </a>
        </div>
    </section>
    <?php endif; ?>
</main>