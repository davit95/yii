<?php
    use yii\helpers\Html;
    foreach ($meta as $key) {
        $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
    }
    $this->title = $title;
?>
<main class="static-page">
	<section class="contact-us white">
		<div class="container">
            <h2 class="weigth_normal">
                <?= Yii::t('dmca',"Dmca")?>
            </h2>
            <p class="weigth_normal">
                <div class="b"> 
                <?= Yii::t('dmca',"Copyright Policy")?>
                </div>
            </p>
            <p class="weigth_normal">
           <?= Yii::t('dmca',"To users, note that {link} only provides proxy service and not file-hosting. But we do our best to find and delete illegal contents, which are reported by our users. We take copyright violation very seriously and we are committed to protecting the rights of copyright owners. All premiumlinkgenerator.com users are bound by the Terms of Use and the law to respect owners’ rights. Users are not allowed to copy, adapt, distribute, or publicly display or perform works of the original work without the authorization of the respective copyright owner.In case you saw something illegal, i.e. persons under the age of 18 in a video or people doing illegal activities, please immediately report it to us by sending the links and file address or number. In the event that you find a content that you own with copyrights and want to remove it, you can simply send us an e-mail at [insert e-mail address here]. Make sure that your message contains the terms 'dmca', 'copyright', 'removal', so we can easily screen it since we are receiving a lot of e-mails.We will immediately stop and further prevent copyright violation upon notice. If a user was found to violate Copyright policy, then he/she will face consequences. {link} follows a three strikes policy. Once we receive a valid notice that a user’s account is disobeying our Copyright Policy, we will immediately disable all access to the material including the user’s access and deactivate the sharing function. The user will be notified through e-mail regarding our actions together with the information that his/her violation has been put on the record for that account under the ‘three-strike’ rule of the Repeat Infringer Termination Policy. The file-sharing function will only be reactivated once the user certifies through an electronic signature option on {link} website that he/she removed all copyright infringing material from his/her account. In the case that the user has violated the Copyright Policy for the third time, the user’s account will be terminated and the user will be permanently banned in {link}",['link'=>HTML::a('http://premiumlinkgenerator.com','http://premiumlinkgenerator.com',['target'=>'_blank','style'=>'color:blue'])])?>
            </p>
		</div>
	</section>
</main>