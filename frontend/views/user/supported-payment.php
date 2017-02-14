<?php 
    use yii\helpers\Url;
    
    $this->title = $title;

    foreach ($meta as $key) {
        $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
    }
    $hostsNum = $hosts->count();
?>
<main class="">
    <section class="supported-file-hosts">
        <div class="container">
            <h1 class="thin tx-white" style = "text-align:center" ><?= Yii::t('suported_payment_methods',"Supported Payment methods")?></h1>
            <h5 class="tx-lblue"><?= Yii::t('hosts',"One of the best things about our website is that we present a wide range of payment methods. Therefore, anyone can easily avail the services we offer. We understand the concern of our clients regarding the safety and security of their personal information. As prevention of fraud, illegal, and unauthorized activities, we subject all payments form in verification and review processes. Thus, we can guarantee our clients that our payment options are trustworthy and reliable. If the transaction appears suspicious, we reserve the right to refuse it. You can avail our services using any of the following payment options:") ?></h5>        
        </div>
    </section>
    <section class="file-hosts white">
        <div class="container">
            <div class="img">
                <img class="sm-fw img" src="/images/payment_method.png" />
            </div> 
        </div>
    </section>
    <?php if (Yii::$app->user->isGuest): ?>
    <section class="call-to-action">
        <div class="container">
            <h4 class="thin"><?=Yii::t('homepage',"Join Today and download EVERYTHING from EVERYWHERE") ?><br><?=Yii::t('homepage','{host_number} File Hosts in one Account',['host_number'=>$hostsNum]) ?></h4>
            <a href="<?= Url::to(['auth/register']) ?>"> <button class="big-button yellow-btn"><?= Yii::t('homepage_create_button',"Create Account")?></button> </a>
        </div>
    </section>
    <?php endif; ?>
</main>