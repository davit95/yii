<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\ProductHelper;
use common\models\Product;

$this->title = $title;

foreach ($meta as $key) {
	$this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}

$hostsNum = $hosts->count();
$popDailyPrice = ProductHelper::getMostPopularProduct('daily');
$popLimitedPrice = ProductHelper::getMostPopularProduct('limited');

?>
<main class="pricing-page">
    <section class="blue-gradient upgrade-account">
        <div class="container ta-center">
            <h1 class="lthin tx-white"><?= Yii::t('price',"Why Upgrade Account")?></h1>
            <div class="col-md-3">
                <div class="img"><img src="/images/upgrade1.png" />
                </div>
                <h5 class='tx-white'><?= Yii::t('price',"Fast Downloads {tag} From Over {host_number} Hosts",['tag'=>Html::tag('br'),'host_number'=>$hostsNum])?></h5><div class='tx-lblue'><?= Yii::t('price',"We offer the most number of file hosts in the market, ensuring blazing fast downloads. Get your files from Turbobit, Upload.net, Filepost and so much more!")?></div>
            </div>
            <div class="col-md-3">
                <div class="img"><img src="/images/upgrade2.png" />
                </div>
                <h5 class='tx-white'><?= Yii::t('price',"No 24-Hour Download {tag} Limits",['tag'=>Html::tag('br')])?></h5><div class='tx-lblue'><?= Yii::t('price',"Download as many files as you want without worrying about daily limits. It doesn’t matter which host you use or how big the files.")?></div>
            </div>
            <div class="col-md-3">
                <div class="img"><img src="/images/upgrade3.png" />
                </div>
                <h5 class='tx-white'><?= Yii::t('price',"No Parallel Download {tag} Limits",['tag'=>Html::tag('br')])?></h5><div class='tx-lblue'><?= Yii::t('price',"Download as many files at the same time as you want, from as many hosts as you want.")?></div>
            </div>
            <div class="col-md-3">
                <div class="img"><img src="/images/upgrade4.png" />
                </div>
                <h5 class='tx-white'><?= Yii::t('price',"Money-Back {tag} Guarantee",['tag'=>Html::tag('br')])?></h5><div class='tx-lblue'><?= Yii::t('price',"Not satisfied with our services? You can get your money back thanks to our foolproof Money-Back Guarantee.")?></div>
            </div>
        </div>
    </section>
    <section class="choose-your-plan white">
        <div class="container ta-center">
            <h2><?= Yii::t('price',"Choose Your Plan")?></h2>
                <ul>
                    <?php foreach ($daysProducts as $product): ?>
                        <li class="price-plan <?= ($popDailyPrice != null && $popDailyPrice->id == $product->id) ? 'most-popular' : ''; ?>">
                            <?php if ($popDailyPrice != null && $popDailyPrice->id == $product->id): ?>
                                <div class="customer-choice">
                                    <div class="uppercase h5 b tx-yellow">Most popular</div>
                                    <div class="tx-yellow percent"><?= ProductHelper::getProductUsage($popDailyPrice) ?>% of customers choose</div>
                                </div>
                            <?php endif; ?>
                            <div class="period h3 uppercase tx-blue">
                                <?php echo $product->days; ?> <span class="lthin">Days</span>
                            </div>
                            <ul class="options">
                                <li class="price">
                                    <h4>$<?= $product->price; ?></h4>
                                </li>
                                <li>
                                    <div class="img"><img src="/images/infinity.png" />
                                    </div>
                                    <div class="liter">Unlimited Traffic</div>
                                </li>
                                <li>
                                    <?php if (null != $plan): ?>
                                        <?php if ($plan->product_type == $product->type): ?>
                                            <a href="<?= '/'.$lang_path.'/order/create/product/'.$product->id ?>" class="btn yellow-btn uppercase full-width buy_button mozila_button">Order</a>
                                        <?php else: ?>
                                            <a href="javascript:void(0)" class="btn yellow-btn uppercase full-width buy_button mozila_button disabled">Order</a>
                                        <?php endif; ?>
                                    <?php elseif (!Yii::$app->user->isGuest): ?>
                                        <a href="<?= '/'.$lang_path.'/order/create/product/'.$product->id ?>" class="btn yellow-btn uppercase full-width buy_button mozila_button">Order</a>
                                    <?php else: ?>
                                        <a href="<?= '/'.$lang_path.'/order/create/product/'.$product->id ?>" class="btn yellow-btn uppercase full-width buy_button mozila_button">Sign up</a>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="ta-center cf clr">
                    <?= Html::a(Yii::t('price_button',"Supported File Hosts"), ['/supported-hosts'], ['class'=>' btn transparent-btn']) ?>
                </div>
        </div>
    </section>
    <section class="choose-your-plan blue-gradient">
        <div class="container ta-center">
            <h4 class='tx-white lthin'><?= Yii::t('price',"Don't Like To Subscribe? {tag} Simply choose from the gigabyte packages on offer that won't expire!",['tag'=>Html::tag('br')])?></h4>
                <ul>
                    <?php foreach ($limitProducts as $product): ?>
                        <li class="price-plan <?= ($popLimitedPrice != null && $popLimitedPrice->id == $product->id) ? 'most-popular' : ''; ?>">
                            <?php if ($popLimitedPrice != null && $popLimitedPrice->id == $product->id): ?>
                                <div class="customer-choice">
                                    <div class="uppercase h5 b tx-yellow">Most popular</div>
                                    <div class="tx-yellow percent"><?= ProductHelper::getProductUsage($popLimitedPrice) ?>% of customers choose</div>
                                </div>
                            <?php endif ?>
                            <div class="period h3 uppercase tx-blue">
                                <?php echo $product->limit; ?><span class="lthin">gb</span>
                            </div>
                            <ul class="options">
                                <li class="price">$
                                    <?php echo $product->price; ?></h4>
                                </li>
                                <li>
                                    <div class="img"><img src="/images/infinity.png" />
                                    </div>
                                    <div class="liter">Unlimited Traffic</div>
                                </li>
                                <li>
                                    <?php if (null != $plan): ?>
                                        <?php if ($plan->product_type == $product->type): ?>
                                            <a href="<?= '/'.$lang_path.'/order/create/product/'.$product->id ?>" class="btn yellow-btn uppercase full-width buy_button mozila_button">Order</a>
                                        <?php else: ?>
                                            <a href="javascript:void(0)" class="btn yellow-btn uppercase full-width buy_button mozila_button disabled">Order</a>
                                        <?php endif; ?>
                                    <?php elseif (!Yii::$app->user->isGuest): ?>
                                        <a href="<?= '/'.$lang_path.'/order/create/product/'.$product->id ?>" class="btn yellow-btn uppercase full-width buy_button mozila_button">Order</a>
                                    <?php else: ?>
                                        <a href="/login" class="btn yellow-btn uppercase full-width buy_button mozila_button">Sign up</a>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
        </div>
    </section>
    </form>
    <?php if (Yii::$app->user->isGuest): ?>
    <section class="call-to-action">
        <div class="container">
            <h2 class=""><?= Yii::t('price',"Try 7 Free-trial days")?></h2>
            <div><?= Yii::t('price',"We offer you 7 free-trial days when registered to help you form your opinion about our services.")?></div>
            <a href="/register">
                <button class="big-button yellow-btn weigth_normal"><?= Yii::t('price_button',"Create AN Account") ?></button>
            </a><br>
            <div class='thin price-font'>
            <small>
                <?= Yii::t('price',"This offer is restricted to new members only {tag} 10 Gb download limit per day",['tag'=>Html::tag('br')])?>
            </small>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <section class="payment-methods">
        <div class="container ta-center">
            <h2><?= Yii::t('price',"We Accept")?></h2>
                <div class="img">
                    <img class="sm-fw" src="/images/payment_method.png" />
                </div>
            </div>
        </div>
    </section>
    <section class="gray advantages">
        <div class="container ta-center">
            <div class="col-md-4">
                <div class="img"><img src="/images/advantage1.png" />
                </div>
                <h5 class='tx-blue'><?= Yii::t('price',"100% Security Guarantee")?></h5><div class='thin'><?= Yii::t('price',"All your payments are carried out via")?><br> <?= Yii::t('price',"very reliable third-party companies")?></div>
            </div>
            <div class="col-md-4">
                <div class="img"><img src="/images/advantage2.png" />
                </div>
                <h5 class='tx-blue'><?= Yii::t('price',"Safety is out Nr1 Priority")?></h5><div class='thin'><?= Yii::t('price',"All your data stays unknown!")?><br> <?= Yii::t('price',"absolutely safe environment")?></div>
            </div>
            <div class="col-md-4">
                <div class="img"><img src="/images/advantage3.png" />
                </div>
                <h5 class='tx-blue'><?= Yii::t('price',"Anonymity is guaranteed")?></h5><div class='thin'><?= Yii::t('price',"All your data stays unknown!")?><br> <?= Yii::t('price',"Nobody will ever know your")?><br><?= Yii::t('price',"payment details")?></div>
            </div>
        </div>
    </section>
</main>
