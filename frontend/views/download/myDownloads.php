<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = $title;

foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}

$groupedUnrestLinks = array();
foreach ($unrestrainedLinks as $unrestrainedLink) {
    $created = Yii::$app->formatter->asDate($unrestrainedLink->created, 'php:d M Y');
    if (!isset($groupedUnrestLinks[$created])) {
        $groupedUnrestLinks[$created] = array();
    }
    $groupedUnrestLinks[$created][] = $unrestrainedLink;
}

?>
<!-- MY DOWNLOADS BEGIN -->
<section class="my-downloads-content" style="display: block">
	<div class="h4 thin"><?=Yii::t('user_profile', 'My Downloads') ?></div>

	<div class="thin">Downloads will be removed after 3 days</div><br>

    <?php foreach ($groupedUnrestLinks as $created => $unrestLinks): ?>
        <div class="b"><?= $created ?></div>
        <ul class="gray-list">
        <?php foreach ($unrestLinks as $unrestLink): ?>
            <li class="cf tx-blue">
    			<img src="/images/arrow_up.jpg">
    			<span class=""><a href="<?= $unrestLink->getInnerDownloadLink() ?>"><?= $unrestLink->getShortenedContentName() ?></a></span>
    			<div class="col-md-3 ta-right right">
    				<?= $unrestLink->formattedContentSize ?>
    				<a href="#" class="js-delete-link" data-id="<?= $unrestLink->id ?>"><i class="fa fa-trash"></i></a>
    			</div>
    		</li>
        <?php endforeach; ?>
        </ul><br><br>
    <?php endforeach; ?>

	<div class="ta-center">
		<nav>
            <?=
                LinkPager::widget(['pagination' => $pag,
                    'pageCssClass' => 'page-item',
                    'linkOptions' => ['class' => 'page-link']]);
            ?>
		</nav>
	</div>
</section>
<!-- MY DOWNLOADS END -->
