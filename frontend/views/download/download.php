<?php

use yii\helpers\Url;
use common\models\Host;

$this->title = $title;

foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}

?>
<!-- DOWNLOAD NOW BEGIN -->
<section class="download-now-content" style="display:block">
	<div class="h4 thin"><?=Yii::t('user_profile', 'Download Now') ?></div>

	<div class="row">
		<div class="col-md-4">
			<div class="input">
				<div>Password (optional):</div>
				<input type="password" name="password" class="pass" />
			</div>
		</div>
		<div class="col-md-4 right">
			<div class="download-info gray-item">
				<div class="b">Downloads info</div>
				<div class="item cf clr thin lh">
					<div class="caption">Days used/left:</div>
					<div class="value"><?= ($daysUsed !== null) ? "{$daysUsed} / {$daysLeft}" : "NA"; ?></div>
				</div>
				<div class="item cf clr thin lh">
					<div class="caption">Downloaded:</div>
					<div class="value"><?= ($bytesDownloaded !== null) ? Yii::$app->formatter->asShortSize($bytesDownloaded) : "NA"; ?></div>
				</div>
				<div class="tx-blue"><a href="<?= Url::to(['@profile_my_transactions']) ?>">Payments made each month</a></div>
			</div>
		</div>
	</div>
	<div class="input">
		<div>Insert host links (one link per line):</div>
		<textarea class="links" name="links"></textarea>
	</div>
	<div class="ta-left group-btn">
		<button id="submit-links" class="yellow-btn">Unrestrain my links</button>&nbsp;&nbsp;&nbsp;
		<a id="clear-links" href="#" class="link tx-blue link">Delete all links</a>
	</div><br><br>
    <?= $this->render('_linksList') ?>
    <br><br>

    <?php if (!empty($limitedHosts)): ?>
    	<div class="h4 thin">Limited hosts</div>
    	<ul class="thin row">
            <?php foreach ($limitedHosts as $host): ?>
                <li class="col-md-6">
        			<a href="#">
        				<img src="<?= substr($host->getLogoUrl(Host::LOGO_SMALL), 3) ?>"/>
        				<?= $host->name ?> (0/<?= $host->limit ?>Mb)
        			</a>
        		</li>
            <?php endforeach; ?>
    	</ul>
    <?php endif; ?>

</section>
<!-- DOWNLOAD NOW END -->
