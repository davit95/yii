<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\ProfileAsset;

ProfileAsset::register($this);

$this->title = $title;

foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}

$pagLinks = $pag->getLinks();

?>
<!-- VOUCHERS BEGIN -->
<section class="vouchers-content" style="display: block;">
    <div class="h4 thin"><?=Yii::t('reseller_profile', 'Vouchers') ?></div>

    <?php if (isset($successMessage) && $successMessage != null): ?>
        <div class="alert alert-success"><?= $successMessage; ?></div>
    <?php elseif (isset($errorMessage) && $errorMessage != null): ?>
        <div class="alert alert-warning"><?= $errorMessage; ?></div>
    <?php endif; ?>

    <div class="filter thin">
        Show&nbsp;
        <select name="per-page">
            <option <?= ($pag->pageSize == 10) ? 'selected' : ''?>>10</option>
            <option <?= ($pag->pageSize == 20) ? 'selected' : ''?>>20</option>
            <option <?= ($pag->pageSize == 30) ? 'selected' : ''?>>30</option>
        </select>&nbsp;
        entries
    </div><br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="ta-center sm-hide xs-hide">Date</th>
                <th class="ta-center">Voucher</th>
                <th class="ta-center sm-hide xs-hide">Status</th>
                <th class="ta-center sm-hide xs-hide">Used</th>
                <th class="ta-center sm-hide xs-hide">Payed</th>
                <th class="ta-center sm-hide xs-hide"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vouchers as $voucher): ?>
            <tr>
                <td class="ta-center sm-hide xs-hide"><?= Yii::$app->formatter->asDate($voucher->created, 'php:d M Y') ?></td>
                <td class="ta-center"><?= $voucher->voucher ?></td>
                <td class="ta-center sm-hide xs-hide"><?= $voucher->status ?></td>
                <td class="ta-center sm-hide xs-hide"><?= ($voucher->used != null) ? Yii::$app->formatter->asDate($voucher->used, 'php:d M Y') : '-'; ?></td>
                <td class="ta-center sm-hide xs-hide"><?= ($voucher->is_payed) ? 'Yes' : 'No'; ?></td>
                <td class="ta-center tx-blue sm-hide xs-hide">
                    <a href="<?= Url::to(['@reseller_voucher','id' => $voucher->id]) ?>">Details</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($vouchers)): ?>
            <tr>
                <td class="ta-center sm-hide xs-hide" colspan="7">No vouchers</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if (!empty($vouchers)): ?>
    <div class="thin">
        <div class="left">Showing <?= $pag->offset + 1 ?> to <?= $pag->offset + count($vouchers) ?> of <?= $pag->totalCount ?> entries</div>
        <nav class="right">
            <?php if (isset($pagLinks['prev'])): ?>
            <a href="<?= $pagLinks['prev'] ?>" class="tx-blue link pointer"><i class="fa fa-angle-double-left"></i> Previous</a>
            <?php endif; ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <?php if (isset($pagLinks['next'])): ?>
            <a href="<?= $pagLinks['next'] ?>" class="tx-blue link pointer">Next <i class="fa fa-angle-double-right"></i></a>
            <?php endif; ?>
        </nav>
    </div>
    <?php endif;?>
</section>
<!-- VOUCHERS END -->
