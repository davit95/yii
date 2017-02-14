<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\helpers\ReferralHelper;
use frontend\assets\ProfileAsset;
use frontend\assets\ChartJsAsset;
use common\models\ReferralLink;
use common\models\ReferralAction;
use common\models\ReferralJournal;

ProfileAsset::register($this);
ChartJsAsset::register($this);

$this->title = $title;

$user = Yii::$app->user->identity;

$daysInMonth = date('t', time());
$startDate = strtotime(date('Y-m-01', time()));
$endDate = strtotime(date('Y-m-'.$daysInMonth, time()));

$firstRefLink = $refLinks->one();

$maxReferralPoints = ReferralAction::find()->max('points');

foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}
?>
<!-- REFERAL BEGIN -->
<section class="referal-content" style="display: block;">
    <div class="h4 thin"><?=Yii::t('user_profile', 'Referal') ?></div>

    <div class="b lh2">Referral, what is it?</div>
    <div class="thin lh">
        You can gain free premium days or points using the referral method. Whenever someone registers to Premium Link Generator premium status using the referral link from your account, you can get <strong><?= $maxReferralPoints ?> referral </strong> points or <strong><?= ReferralHelper::referralPointsToPremiumDays($maxReferralPoints) ?></strong> premium days. The points can be used to extend the period for your premium account or <strong> create vouchers for your friends.</strong> At the bottom of this page, you can get the referral links, banners, and other information.
        <!-- If you refer someone (who registers with the referral link from your account) and they buy the AllDebrid premium status, we will offer you: <strong><?= $maxReferralPoints ?> referral</strong> points or <strong><?= ReferralHelper::referralPointsToPremiumDays($maxReferralPoints) ?> premium days</strong>
        Use these points to extend your premium account , or <strong>generate vouchers for your friends.</strong>
        You can find your referral links, banners and more information at the bottom of this page. -->
    </div><br><br>

    <div class="b lh2">Currently, you have. <span class="tx-red"><?= $user->referral_points ?></span> points from <?= $refClicks ?> clicks.</div>
    <ul class="thin lh2" style="padding-left:20px;">
        <li>• Get <?= ReferralHelper::referralPointsToPremiumDays($user->referral_points) ?> days to extend your premium account.</li>
        <li>• Create 0 vouchers containing <span class="tx-red">3</span> premium days for your friends.</li>
    </ul><br>

    <div class="b lh2">Earnings per day</div>
    <div id="earnings-filter-error-container"></div>

    <section class="gray-item cf earnings-per-day">
        <div class="col-md-6 input">
            <select name="refLinkId">
                <?php foreach ($refLinks->each() as $refLink): ?>
                    <option value="<?= $refLink->id ?>"><?= $refLink->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2 input start-date">
            <input  name="startDate" type="text" class="full-width datepicker" placeholder="Start date" value="<?= Yii::$app->formatter->asDate($startDate, 'php:Y-m-d') ?>"/>
        </div>
        <div class="col-md-2 input end-date">
            <input name="endDate" type="text" class="full-width datepicker" placeholder="End date" value="<?= Yii::$app->formatter->asDate($endDate, 'php:Y-m-d') ?>"/>
        </div>
        <div class="col-md-2 button">
            <a href="#" id="apply-filter" class="btn btn-default full-width">Apply</a>
        </div>
    </section>

    <section id="chart-section" class="bar-chart gray-item cf">
        <div class="image" height="329" width="688">
            <?= $this->render('_chart', [
                'refLink' => $firstRefLink,
                'startDate' => $startDate,
                'endDate' => $endDate
            ]); ?>
        </div>
    </section>

    <section id="avg-clicks-per-day-section" class="gray-item cf">
        <?= $this->render('_avgClicksPerDay', [
            'refLink' => $firstRefLink,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]); ?>
    </section>

    <section id="avg-leads-per-day-section" class="gray-item cf">
        <?= $this->render('_avgLeadsPerDay', [
            'refLink' => $firstRefLink,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]); ?>
    </section><br><br>

    <div class="cf clr">
        <div class="b lh2 left">Payments made each month</div>
        <?php if (!empty($payments)): ?>
        <div class="tx-blue link pointer right">
            <img src="<?= Url::to('@web/images/pdf_icon.png') ?>"/> <a href="<?= Url::to(['@profile_referral_download_invoice']) ?>">Download Invoice</a>
        </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($payments)): ?>
        <?php foreach ($payments as $month => $amount): ?>
            <section class="gray-item cf">
                <div class="left"><?= $month ?></div>
                <div class="right"><?= $amount ?></div>
            </section>
        <?php endforeach; ?>
    <?php else: ?>
        <section class="gray-item cf">
            <div class="ta-center">No payments</div>
        </section>
    <?php endif; ?>
    <br><br>
    <div class="b lh2">Refer someone</div>
    <section class="gray-item cf refer-someone">
        <div class="thin"> Provide this link to the person you wish to refer:</div><br>
        <?php foreach ($refLinks->where(['type' => ReferralLink::TYPE_DIRECT])->each() as $refLink): ?>
            <div class="row">
                <div class="col-md-2 thin"><?= $refLink->name ?> :</div>
                <div class="col-md-10">
                    <div class="input"><input type='text' value="<?= Html::encode($refLink->getLink($user)) ?>"/></div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php foreach ($refLinks->where(['type' => ReferralLink::TYPE_PHPBBFORUM])->each() as $refLink): ?>
            <div class="row">
                <div class="col-md-2 thin"><?= $refLink->name ?> :</div>
                <div class="col-md-10">
                    <div class="input"><input type='text' value="<?= Html::encode($refLink->getLink($user)) ?>"/></div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php foreach ($refLinks->where(['type' => ReferralLink::TYPE_IMAGE])->each() as $refLink): ?>
            <div class="row">
                <div class="col-md-2 thin"><?= $refLink->name ?> :</div>
                <div class="col-md-10">
                    <div class="input"><input type='text' value="<?= Html::encode($refLink->getLink($user)) ?>"/></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 thin">Preview :</div>
                <div class="col-md-10">
                    <div class="img"><?= $refLink->getLink($user) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </section><br><br>

    <div class="b lh2">Service presentation</div>
    <section class="gray-item cf">
        <div class="input">
        <textarea readonly><?= ReferralHelper::getPresentationText() ?></textarea>
        </div>
    </section><br>
    <div class="ta-center tx-blue"><a href="#" class="link" data-toggle="modal" data-target="#modal-services-presentation">View the result</a></div><br><br>

    <div class="b lh2">List of hosts (BBCODE, with icons)</div>
    <section class="gray-item cf">
        <div class="input">
        <textarea readonly><?= ReferralHelper::getBbCodeHostsLogos() ?></textarea>
        </div>
    </section><br>
    <div class="ta-center tx-blue"><a href="#" class="link" data-toggle="modal" data-target="#modal-bbcode-hosts-logos">View the result</a></div><br><br>

    <div class="b lh2">Organized hosts list (BBCODE, with icons)</div>
    <section class="gray-item cf">
        <div class="input">
        <textarea readonly><?= ReferralHelper::getBbCodeHostsLogosList() ?></textarea>
        </div>
    </section><br>
    <div class="ta-center tx-blue"><a href="#" class="link" data-toggle="modal" data-target="#modal-bbcode-hosts-logos">View the result</a></div><br><br>
</section>
<!-- REFERAL END -->

<!-- MODALS -->
<div class="modal fade" id="modal-services-presentation" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="myModalLabel">Service presentation</h5>
            </div>
            <div class="modal-body">
                <?= ReferralHelper::getPresentationText() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-bbcode-hosts-logos" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="myModalLabel">List of hosts (BBCODE, with icons)</h5>
            </div>
            <div class="modal-body">
                <?php foreach (ReferralHelper::getBbCodeHostsLogosPreview() as $hostPreview): ?>
                    <?= $hostPreview ?>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODALS -->
