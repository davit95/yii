<?php

use yii\helpers\Url;
use frontend\assets\ProfileAsset;

ProfileAsset::register($this);

$this->title = $title;

foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}

$pagLinks = $pag->getLinks();

?>
<!-- PRODUCTS BEGIN -->
<section class="products-content" style="display: block;">
    <div class="h4 thin"><?=Yii::t('reseller_profile', 'Products') ?></div>

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
                <th class="ta-center">Product</th>
                <th class="ta-center">Description</th>
                <th class="ta-center">Sell price</th>
                <th class="ta-center">Your price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td class="ta-center"><?= $product->name ?></td>
                <td class="ta-center"><?= $product->description ?></td>
                <td class="ta-center"><?= $product->price.' '.$product->price_currency ?></td>
                <td class="ta-center"><?= (($fee != null ) ? $fee->applyDiscount($product->price) : $product->price).' '.$product->price_currency ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($products)): ?>
            <tr>
                <td class="ta-center sm-hide xs-hide" colspan="7">No products</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if (!empty($products)): ?>
    <div class="thin">
        <div class="left">Showing <?= $pag->offset + 1 ?> to <?= $pag->offset + count($products) ?> of <?= $pag->totalCount ?> entries</div>
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
<!-- PRODUCTS END -->
