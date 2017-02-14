<?php

use yii\helpers\Url;
use common\models\Host;
use yii\helpers\Html;

$this->title = $title;

$hostsNum = $hosts->count();
$colsNum = 4;
$index = 1;
$cols = array();
foreach ($hosts->each() as $host) {
    $cols[$index % $colsNum][] = $host;
    $index++;
}
foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}
?>
<main class="">
    <section class="supported-file-hosts">
        <div class="container">
            <h1 class="lthin tx-white"> <?= Yii::t('hosts',"Supported File Hosts") ?></h1>
            <h5 class="tx-lblue"><?= Yii::t('hosts',"Below is the list of supported file hosts. Using our website, you only need to have one premium account and you can download in several file hosts included in our list. However, it doesn’t simply stop here because we are continuously including new hosts. We also take special requests from our clients. Thus, if you want to download files in other hosts you can send a request to us.") ?></h5>
        </div>
    </section>

    <section class="file-hosts white">
        <div class="container">
            <div class="row">
                <h2 class="ta-center"><?= Yii::t('hosts',"{host_number} File Hosts",['host_number'=>$hostsNum]) ?></h2>
                <?php foreach ($cols as $col): ?>
                        <div class="col-md-3">
                            <ul>
                                <?php foreach ($col as $host): ?>
                                    <?php 
                                    $url = substr($host->getLogoUrl(Host::LOGO_SMALL), 3);
                                    ?>
                                    
                                    <li class="weigth_normal">
                                        <a href=<?= '/'.$lang_path."/hosts/".explode('.',$host->name)[0]?> > 
                                        <img class = "hosts-style_uptime" src="/images/icons/<?= $host->logo?>"><?= $host->name ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="call-to-action">
        <div class="container">
            <h4 class="thin"><?= Yii::t('hosts',"Join Today and download EVERYTHING from EVERYWHERE {tag} {host_number} File Hosts in one Account",['tag'=>Html::tag('br'),'host_number'=>$hostsNum]) ?></h4>
            <a href="<?= Url::to(['user/price']) ?>"> <button class="big-button yellow-btn"><?= Yii::t('hosts_button','Upgrade Account') ?></button> </a>
        </div>
    </section>

</main>