<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\captcha\Captcha;

    $this->title = $title;

    foreach ($meta as $key) {
        $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
    }
?>
<!-- UPTIME AND OVERVIEW BEGIN -->
<section class="overview-content" style="display: block">
    <div class="h4 thin"><?=Yii::t('user_profile', 'Uptime and Overview') ?></div>
    <div class="thin lh">
        From our wild imagination We acknowledged that the clouds are the future, but saw much more potential in them. When everybody was just storing files in their online drives, synching them with their mobiles and sharing them with others, we imagined something that would push this cloud experience to a whole other Level. Something like a "Genius Servant", "a Wiz", a "Brilliant Secretary" that would work for you: interconnect all your clouds so you would have endless storage space and one window simplicity! We knew what we wanted and how to execute it...
    </div><br>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="overview-list">
                <div class="heading cf clr">
                    <div class="col-md-6 h5 col-sm-6 col-xs-6">File Hosts</div>
                    <div class="col-md-6 h5 col-sm-6 col-xs-6">Last Check</div>
                </div>
                <div class="fs13 cf clr">
                    <?php
                        $countHosts = count($hosts)
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <ul>
                            <?php for ($i = 0; $i < floor($countHosts / 2); $i++): ?>
                                <li>
                                    <img class = "hosts-style_uptime" src="/images/icons/<?= $hosts[$i]->logo?>">
                                    <?= $hosts[$i]->name?>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                    <div class="col-md-6 liter col-sm-6 col-xs-6">
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
        <div class="col-md-6 col-sm-6">
            <div class="overview-list">
                <div class="heading cf clr">
                    <div class="col-md-6 h5 col-sm-6 col-xs-6">File Hosts</div>
                    <div class="col-md-6 h5 col-sm-6 col-xs-6">Last Check</div>
                </div>
                <div class="fs13 cf clr">
                    <?php
                        $countHosts = count($hosts)
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <ul>
                            <?php for ($i = floor($countHosts / 2); $i < $countHosts; $i++): ?>
                                <li>
                                    <img class = "hosts-style_uptime" src="/images/icons/<?= $hosts[$i]->logo?>">
                                    <?= $hosts[$i]->name?>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                    <div class="col-md-6 liter col-sm-6 col-xs-6">
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
</section>
<!-- UPTIME AND OVERVIEW END -->
