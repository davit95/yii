<?php
    use common\models\Host;

    foreach ($meta as $key) {
        $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
    }
    $this->title = $title;
?>

<main class="">
    <section class="uptime-and-overview">
        <div class="container">
            <h1 class="lthin tx-white"><?= Yii::t('uptime_and_overview',"Uptime and Overview")?></h1>
            <h5 class="tx-lblue"><?= Yii::t('uptime_and_overview',"Because transparency metters, here is a live status of hosts availability")?></h5>
        </div>
    </section>

    <section class="overview white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="description"><?= Yii::t('uptime_and_overview',"From our wild imagination... We acknowledged that the clouds are the future, but saw much more potential in them. When everybody was just storing files in their online drives, synching them with their mobiles and sharing them with others, we imagined something that would push this cloud experience to a whole other Level. Something like a \"Genius Servant\", \"a Wiz\", a \"Brilliant Secretary\" that would work for you: interconnect all your clouds so you would have endless storage space and one window simplicity! We knew what we wanted and how to execute it...")?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="overview-list">
                        <div class="heading cf clr">
                            <div class="col-md-6 h5 col-sm-5"><?= Yii::t('uptime_and_overview',"File Hosts")?></div>
                            <div class="col-md-6 h5 col-sm-5"><?= Yii::t('uptime_and_overview',"Last Check")?></div>
                        </div>
                        <div class="fs13 cf clr">
                            <?php
                                $countHosts = count($hosts)
                            ?>
                            <div class="col-md-6 col-xs-6">
                                <ul>
                                    <?php for ($i = 0; $i < floor($countHosts / 2); $i++): ?>
                                        <li class="icon_fonts">
                                            <img class = "hosts-style_uptime" src="/images/icons/<?= $hosts[$i]->logo?>">
                                            <?= $hosts[$i]->name?>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                            <div class="col-md-6 liter col-xs-6">
                                <ul>
                                    <?php for ($i = 0; $i < floor($countHosts / 2); $i++): ?>
                                        <li>
                                            <?php if ($hosts[$i]->status=="active"): ?>
                                                <img src="/images/check.png"/>
                                                <?= \Yii::$app->formatter->asDatetime($hosts[$i]->updated_at, "php:Y-m-d H:i:s"); ?>
                                            <?php elseif ($hosts[$i]->status=="inactive"): ?>
                                                <img src="/images/block.png"/>
                                                <?= \Yii::$app->formatter->asDatetime($hosts[$i]->updated_at, "php:Y-m-d H:i:s"); ?>
                                            <?php endif; ?>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="overview-list">
                        <div class="heading cf clr">
                            <div class="col-md-6 h5 col-sm-5"><?= Yii::t('uptime_and_overview',"File Hosts")?></div>
                            <div class="col-md-6 h5 col-sm-5"><?= Yii::t('uptime_and_overview',"Last Check")?></div>
                        </div>
                        <div class="fs13 cf clr">
                            <?php
                                $countHosts = count($hosts)
                            ?>
                            <div class="col-md-6 col-xs-6">
                                <ul>
                                    <?php for ($i = floor($countHosts / 2); $i < $countHosts; $i++): ?>
                                        <li class="icon_fonts">
                                            <img class = "hosts-style_uptime" src="/images/icons/<?= $hosts[$i]->logo?>">
                                            <?= $hosts[$i]->name?>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                            <div class="col-md-6 liter col-xs-6">
                                <ul>
                                    <?php for ($i = floor($countHosts / 2); $i < $countHosts; $i++): ?>
                                        <li>
                                            <?php if ($hosts[$i]->status=="active"): ?>
                                                <img src="/images/check.png"/>
                                                <?= \Yii::$app->formatter->asDatetime($hosts[$i]->updated_at, "php:Y-m-d H:i:s"); ?>
                                            <?php elseif ($hosts[$i]->status=="inactive"): ?>
                                                <img src="/images/block.png"/>
                                                <?= \Yii::$app->formatter->asDatetime($hosts[$i]->updated_at, "php:Y-m-d H:i:s"); ?>
                                            <?php endif; ?>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>