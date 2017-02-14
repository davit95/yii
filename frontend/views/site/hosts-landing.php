<?php

use yii\helpers\Url;
use common\models\Host;
use yii\helpers\Html;

foreach ($meta as $key) {
	if($key['name'] == 'description' && false !== strpos($key['content'],'[hostname]')){
		$content = str_replace("[hostname]", Yii::$app->request->get('name'), $key['content']);
    	$this->registerMetaTag(['name' => $key->name, 'content' => $content]);
	}
	$this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}

$hostsNum = $hosts->count();
$colsNum = 4;
$index = 1;
$cols = array();
foreach ($hosts->each() as $host) {
    $cols[$index % $colsNum][] = $host;
    $index++;
}

$title = str_replace("[hostname]", Yii::$app->request->get('name'), $title);
$this->title = $title;
?>
	<div class="col-md-6 col-sm-5 col-xs-5">
		<div class="popup premium-download-popup" id="premium_download_popup">
			<div class="popup-content">
				<div class="modal-header md-hide">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		        </div>
				<h5 class="ta-center">We advise you to choose PLG instead of your current option!</h5>
				<div class="thin dark">Premium Link Generator downloads for you without captcha, without waiting and at incredible speeds. </div>
				<div class="unrestrained-hosts">
					<i class="fa fa-angle-right"></i>
					<span class="number"><?= $hostsNum?> hosts</span>
					<span class="thin">currently unrestrained</span>
				</div>
				<ul class="hosts-list">
					<?php foreach ($cols as $col): ?>
		                <?php foreach ($col as $host): ?>
		                    <li class="weigth_normal">
		                        <img class = "hosts-style_uptime" src="/images/icons/<?= $host->logo?>">
		                    </li>
		                <?php endforeach; ?>
					<?php endforeach; ?>
				</ul>
				<div class="ta-center">
					<?php if (null != Yii::$app->user) { ?>
						<?= Html::a("Start Premium Downloading here", ['/download'], ['class'=>' btn yellow-btn uppercase buy_button mozila_button pop_btn','style'=>'margin-top:15px']) ?>
					<?php } else {  ?>
						<?= Html::a("Start Premium Downloading here", ['/login'], ['class'=>' btn yellow-btn uppercase full-width buy_button mozila_button']) ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<main class="">
		<section class="download-from">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-7">
						<h3 class="lthin tx-white"><?= Yii::t('hosts_landing',"Downloading from {host_name}",['host_name'=>$host_obj->name])?></h3>
						<h5 class="tx-white"><?= Yii::t('hosts_landing',"Now you no longer need a Premium Account for it!")?></h5>
						<div class="tx-white"><?= Yii::t('hosts_landing',"Premium Link Generator downloads for you without captcha, without waiting and at incredible speeds")?></div>
						<button class="yellow-btn thin compare_button"><?= Yii::t('hosts_landing',"Premium Link Generator {host_name} - Click Here",['host_name'=>$host_obj->name])?></button>
					</div>
					<div class="col-md-6 col-sm-5">
						<div class="img">
							<img  src="/images/desktop_pc.png"/>
								<img class = "img-top-icons" src="/data/hosts/<?= $host_obj->logo_large?>">
						</div>
					</div>
				</div>
			</div>
		</section>


		<section class="compare white">
			<div class="container ta-center">
				<h2><?= Yii::t('hosts_landing',"Compare")?></h2>
				<ul>
					<li class="labels ta-right compare-margin">
						<div><?= Yii::t('hosts_landing',"Compare max mb/gb")?></div>
						<div><?= Yii::t('hosts_landing',"Download Options")?></div>
						<div><?= Yii::t('hosts_landing',"Pricing")?></div>
					</li>
					<li class="compared-item">
						<div class="name tx-blue"><a href="<?= $host_obj->host_url?>" target= "_blank"><?= $host_obj->name ?></a><br> Premium</div>
						<?php $url = substr($host_obj->getLogoUrl(Host::LOGO_SMALL), 3);?>
						<div class="img host-img">
						<img src="/images/icons/<?= $host_obj->logo?>">
						</div>
						<ul class="options">
							<li><?= $host_obj->max_mb_per_day ?></li>
							<li><?= $host_obj->download_options ?></li>
							<li class="price"><?= $host_obj->pricing ?></li>
							<li><?= Html::a(Yii::t('host_landing',"Learn More"),$host_obj->host_url, ['class'=>'btn-height btn transparent-btn full-width','target'=>'_blank']) ?>
							</li>
						</ul>
					</li>
					<li class="compared-item">
						<div class="name tx-blue">Premium Link <br>Generator</div>
						<div class="img host-img"><img src="/images/plg-blue.png"/></div>
						<ul class="options">
							<li>Unlimited</li>
							<li><?= $hostsNum ?> Website</li>
							<li class="price">12.99 $</li>
							<li>
							<?= Html::a(Yii::t('price_button',"Buy"), ['/price'], ['class'=>' btn yellow-btn uppercase full-width mozila_button','id'=>"buy_premium_btn"]) ?>
							</li>
						</ul>
					</li>
					<li class="labels ta-left compare-margin">
						<div><?= Yii::t('hosts_landing',"Compare max mb/gb")?></div>
						<div><?= Yii::t('hosts_landing',"Download Options")?></div>
						<div><?= Yii::t('hosts_landing',"Pricing")?></div>
					</li>
				</ul>
			</div>
		</section>

		<section class='tablets gray'>
			<div class="ta-center container">
				<div class="img"><img src="/images/tablets.png"/></div>
			</div>
		</section>

		<section class="call-to-action">
			<div class="container">
				<h4 class="thin">
				<?= Yii::t('hosts_landing',"Join Today and download EVERYTHING from EVERYWHERE {tag} {host_number} File Hosts in one Account",['tag'=>Html::tag('br'),'host_number'=>$hostsNum]) ?>
				</h4>
				<a href="<?= Url::to(['user/price']) ?>"> <button class="big-button yellow-btn"><?= Yii::t('hosts_button','Upgrade Account') ?></button> </a>
			</div>
		</section>

	</main>