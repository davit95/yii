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
            <h2 class="weigth_normal"><?= Yii::t('privacy_policy',"Privacy Policy")?></h2>
            <h6><?= Yii::t('privacy_policy',"Premium Link Generator Privacy Policy")?></h6>
            <?= Yii::t('privacy_policy',"Here in {link}, we recognize and respect the privacy of our users over the internet. This page is dedicated to providing information about the privacy and process of collecting data for the site: {link}",['link'=>HTML::a('http://premiumlinkgenerator.com','http://premiumlinkgenerator.com',['style'=>'color:blue','target'=>'_blank'])])?>
            <h6><?= Yii::t('privacy_policy',"The Premium Link Generator Site and Third Party Sites")?></h6>
            <?= Yii::t('privacy_policy',"This Privacy Policy only applies to Premium Link Generator Site. The links to third party sites that Premium Link Generator may contain are not owned or control by us and we assume no responsibility for its content, privacy policies, or practices. Users agree that they are responsible for reviewing and understanding the privacy policy (if any) of any third party sites that users may access through this Site. When you use this Site, you will not hold Premium Link Generator from any and all liability that may arise from using any third-party site to which this Site may be linked.<br>Based on the information that we collect, we use it to provide and improve the Service, the Site, and the related features, to administer users subscription and to enable them to enjoy and easily navigate the Site. Below is the list of types and categories of information that our Site collects.")?>
            <h6><?= Yii::t('privacy_policy_t',"Our Site collects the personal information using:")?></h6>
            <p class="weigth_normal">
                <ul style="list-style-type: circle;">
                    <li><?= Yii::t('privacy_policy',"Registration")?></li>
                </ul>
            </p>
            <?= Yii::t('privacy_policy',"You are required to create an account on our Site to become a user. You need to provide contact information including e-mail address and a password, which you recognize and clearly acknowledge as personal information used to identify you. Your account's password will be sent through the e-mail you provided, which can be changed anytime by logging into your account and editing your My Details section.")?>
            <p class="weigth_normal">
                <ul style="list-style-type: circle;">
                    <li><?= Yii::t('privacy_policy',"Log Data")?></li>
                </ul>
            </p>
            <?= Yii::t('privacy_policy',"Simply browsing our server automatically records information about your use of the Site. The Log Data may contain information, such as your IP address, browser type, the software you were using, pages of the Site that you visited, the time spent on those pages, the information you searched on the Site, access times and dates, and other statistics. The information we collect is used to monitor and analyze the use of the Site and the Service, for the Site technical administration, to improve Site functionality and accessibility, and to customize it depending on our users needs.")?>
            <p class="weigth_normal">
                <ul style="list-style-type: circle;">
                    <li><?= Yii::t('privacy_policy',"Cookies")?></li>
                </ul>
            </p>
            <p class="weigth_normal">
                <?= Yii::t('privacy_policy',"Premium Link Generator uses cookies and web log files like other websites in order to track site usage. One type of cookie that we are using is known as persistent cookie, which allows the Site to recognize you as a user when you return using the same computer and web browser. Thus, you wont need to log in before using the service. If your browser settings don't allow cookies, then you won't be able to login to your Premium Link Generator Premium account. The cookie and log file data is also used to customize your experience on our Site, which is similar to the information that you enter at the registration.")?>
                <h6><?= Yii::t('privacy_policy',"Log files, IP addresses, and information about your computer")?></h6>
                <?= Yii::t('privacy_policy',"When users visit Premium Link Generator site, we automatically receive information from them due to the communications standards on the internet. The information that we receive includes the URL of the site from which users came and the site to which users are going when they leave the Site, IP address of their computer or the proxy server they use to access the internet, their computers operating system and the type of browser they are using, e-mail patterns, and the name of their ISP. The information we received will help us improve the Site service by analyzing overall trends. Third parties won\u2019t get any access to users IP address and personally identifiable information without their permission unless it is required by the law.")?>
                <h6><?= Yii::t('privacy_policy',"Premium Link Generator Communications")?></h6>
                <?= Yii::t('privacy_policy',"Communication between the Site administrators and users will be through e-mail, notices on the forum site, and other means of services like text and other forms of messaging. To change your e-mail and contact preferences, simply log in to your account and edit My Details section.")?>
                <h6><?= Yii::t('privacy_policy',"Sharing Information with Third Parties")?></h6>
                <?= Yii::t('privacy_policy',"The Site gives importance to the privacy of our users. Thus, we do not sell, rent, or provide your personally identifiable information to third parties for marketing purposes. We will only do such thing based on your instructions or to provide specific services or information. For example, we use credit card processing companies to charge users for premium accounts. However, these third parties do not retain, share, or store any personally identifiable information except to provide these services. They are obliged by confidentiality agreements that limit their use of such information.")?>
                <h6><?= Yii::t('privacy_policy',"Phishing")?></h6>
                <?= Yii::t('privacy_policy',"Phishing and identity theft are major concerns on our Site. Thus, protecting our users information is our top priority. We do not and will not, at any time, ask for your personal information including credit card information, your account ID, login password using a non-secure or unsolicited e-mail or via phone call.")?>
                <h6><?= Yii::t('privacy_policy',"Links to Other Sites")?></h6>
                <?= Yii::t('privacy_policy',"You will find third party links in our site but we do not endorse, authorize, or represent any affiliation to these third party websites nor endorse their privacy or information security policies, or practices. We do not control these third party websites. Thus, we encourage our users to read the privacy policies or statements of the other websites you visit. These third party sites may place their own cookies or other files on your computer, collect data or ask personal information from you. They follow different rules regarding the use or disclosure of the personal information you submit to them.")?>
                <h6><?= Yii::t('privacy_policy',"Accessing and Changing your Account Information")?></h6>
                <?= Yii::t('privacy_policy',"The information that users provided on our Site can be reviewed and changed anytime by simply logging into the user's account on the Premium Link Generator site. However, even after the user requested for a change is processed, the Site may for a time retain residual information in its backup and or archival copies of its database")?>
                <h6><?= Yii::t('privacy_policy',"Deleting your Account")?></h6>
                <?= Yii::t('privacy_policy',"Users can easily request to delete their account at any time. Note that Premium Link Generator site may retain certain data contributed by the user, which we believe can be used to prevent fraud or future abuse, legitimate business purposes like analysis of aggregated, non-personally identifiable data, and account recovery, or if required by the law. To delete your account, please send us a request at {support} and it will be deleted as soon as possible.",['support'=>HTML::a('support@premiumlinkgenerator.com','mailto:support@premiumlinkgenerator.com',['style'=>'color:blue'])])?>
                <h6><?= Yii::t('privacy_policy',"Your Obligations")?></h6>
                <?= Yii::t('privacy_policy',"Users also have certain obligations that are imposed by applicable law and regulations:Users must all the time respect the Terms and Conditions of the then-current Privacy Policy and the Terms of Use including all intellectual property rights which may belong to third parties.Users must not download or distribute any information which can be considered to be injurious, violent, offensive, racist, or xenophobic.We take these principles very seriously and consider these to be the basis on which our users follow to the Premium Link Generator Site and the services we offer. Thus, any violation of these guidelines may lead to the restriction, suspension, or termination of user's account.")?>
                <h6><?= Yii::t('privacy_policy',"Changes to This Policy")?></h6>
                <?= Yii::t('privacy_policy',"From time to time, we may revise our privacy policy. Thus, we encourage our users to periodically visit this page to be aware of any such revisions. However, we will not use our users existing information in a method not previously disclosed. Users will be advised and given the choice to opt out of any new use of their information.")?>
                <h6><?= Yii::t('privacy_policy',"How to Contact Us")?></h6>
                <?= Yii::t('privacy_policy',"For any queries or concerns regarding this page, do not hesitate to contact our site coordinator at {support}",['support'=>HTML::a('support@premiumlinkgenerator.com','mailto:support@premiumlinkgenerator.com',['style'=>'color:blue'])])?>
            </p>
		</div>
	</section>
</main>