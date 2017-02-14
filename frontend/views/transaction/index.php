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
<!-- TRANSACTIONS BEGIN -->
<section class="transactions-content" style="display: block;">
    <div class="h4 thin"><?=Yii::t('user_profile', 'Transactions') ?></div>

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
                <th>Date</th>
                <th class="ta-center">Amount</th>
                <th class="ta-center">Days</th>
                <th class="ta-center">Gigabytes</th>
                <th class="ta-center sm-hide xs-hide">Trafic</th>
                <th class="ta-center sm-hide xs-hide">Payment Status</th>
                <th class="ta-center sm-hide xs-hide"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= Yii::$app->formatter->asDate($transaction->timestamp, 'php:d M Y') ?></td>
                <td class="ta-center"><?= $transaction->getAmountWithCurrencySym() ?></td>
                <td class="ta-center"><?= $transaction->getTransactionData('period', '-') ?></td>
                <td class="ta-center"><?= $transaction->getTransactionData('limit', '-') ?></td>
                <td class="ta-center sm-hide xs-hide"><img src="<?= Url::to('@web/images/infinity_green.png') ?>"/></td>
                <td class="ta-center sm-hide xs-hide"><?= $transaction->getTransactionData('payment_status', '-') ?></td>
                <td class="tx-blue sm-hide xs-hide">
                    <img src="<?= Url::to('@web/images/pdf_icon.png') ?>"/>
                    <a href="<?= Url::to(['@profile_my_transactions_download_invoice','id' => $transaction->id]) ?>">Download Invoice</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($transactions)): ?>
            <tr>
                <td class="ta-center sm-hide xs-hide" colspan="7">No transactions</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if (!empty($transactions)): ?>
    <div class="thin">
        <div class="left">Showing <?= $pag->offset + 1 ?> to <?= $pag->offset + count($transactions) ?> of <?= $pag->totalCount ?> entries</div>
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
<!-- TRANSACTIONS END -->
