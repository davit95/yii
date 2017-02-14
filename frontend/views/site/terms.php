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
            <h2 class="weigth_normal"><?= Yii::t('terms',"Terms of use")?></h2>
            <div class="b">
            	<?= Yii::t('terms',"Terms of use")?></h2>
	            <p class='weigth_normal'>
	            <?= Yii::t('terms',"Thank you for visiting the Premium Link Generator website located at {link}. When you access or use the Site and register as a premium member of the Site (Premium Access), it means that you fully agree to follow the Premium Link Generator website Terms and Conditions (Terms and Conditions).The Terms and Conditions are part of Premium Link Generator Policy (Privacy Policy) and any and all other applicable operating rules, policies, price, schedules, and other supplemental terms and conditions, or documents that may be changed every now and then, which are specifically integrated herein by reference (collectively, the Agreement).Please carefully review the Agreement. In case that you don agree to the whole terms and conditions included in the Agreement then you are not allowed to use the Site or Service at all.",['link'=>Html::a('http://premiumlinkgenerator.com','http://premiumlinkgenerator.com',['style'=>'color:blue','target'=>'_blank'])])?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"Scope of Agreement")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"You agree to the terms and conditions stated in the Agreement so that you can use the Site and Services. The Agreement represents the complete and only agreement between you and Premium Link Generator regarding your use of the Site and Services. It replaces all previous or current agreements, warranties, and or understanding regarding your use of the Services, Site, and the content included therein and\/or any other products and services provided by or through same.")?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"Modification of Agreement")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"We may modify the Agreement every now and then depending on our preference, without specific notice to our users. The most recent Agreement is posted on the Site so users should review the Agreement before using the Site. If you choose to continuously use the Site and or Service, you hereby agree to obey with and be obliged by, all the terms and conditions included within the Agreement effective at that time. Thus, we encourage our users to regularly check this page for updates or changes. Any future offer's or products made available on the Site that enhances the current features of the Site will be subjected to the Agreement except clearly stated otherwise. You understand and agree that Premium Link Generator is not responsible or liable in any way if you can use the Site, become a Member, or use the Services.")?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"Registration")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"In order to use Premium Services, you must first register to Premium Link Generator. You must provide information like your e-mail address and other information requested by the Site on the Registration. You agree to provide true, accurate, current, and complete Registration Data in order to maintain it updated and accurate. The Site will verify and approve all Registrations based on its standard verification procedures. Premium Link Generator has the right to deny the Registration of anyone at any time and for any reason. Using your username and password, which you can change based on your preference, you can access your Premium Link Generator account. You are responsible for maintaining the privacy of your account information and restricting access to your computer. You agree to accept responsibility for all the activities that will be done using your Premium Link Generator account including any and all purchases made.")?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"Fair Use Policy")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"It is important that all users enjoy the same quality of service from Premium Link Generator. Users should not abuse the system including, but not limited to, using content which utilizes too much CPU time or storage space, using excessive bandwidth, or reselling access to the content hosted on Premium Link Generator servers. The Site reserves the right to control and restrict accounts that are suspected to be abusing the Service using an advanced system.")?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"Daily Fair Use & Limitations")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"Premium Link Generator has the right to put a limit on downloads of users, which can be daily, weekly, or monthly basis or any other limitations that can be considered necessary by the Site. The limitation can be set by Premium Link Generator to specific filehosters, specific users, or groups of users who are suspected that are not using the Services in a fair way.")?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"Supported Hosters Non-Responsibility")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"Premium Link Generator is NOT responsible when a file-hoster chooses to terminate any contract with the Site. However, the Site gives their best so this won happen.")?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"Account Restrictions")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"Below is the list of things not allowed in Premium Link Generator. If you violated any of the restrictions, the Site has the right to restrict, terminate your account, or change your password.")?>
	            </p>
            </div>
	            <ol>
	            	<li><?= Yii::t('terms',"Sharing of account with other users.")?></li>
	            	<li><?= Yii::t('terms',"Users can publish their account details (username & password) on forums, blogs, or anywhere on the internet")?></li>
	            	<li><?= Yii::t('terms',"Downloading files simultaneously from different IP addresses.")?></li>
	            	<li><?= Yii::t('terms',"Resell the Premium Link Generator Services without any agreement with the Site.")?></li>
	            	<li><?= Yii::t('terms',"Use the Premium Link Generator site to provide similar services.")?></li>
	            	<li><?= Yii::t('terms',"Resell Oron links from Premium Link Generator.")?></li>
	            </ol>
            <div class="b">
            	<?= Yii::t('terms',"Rejection Termination")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"Premium Link Generator can decide to reject your Registration and or terminate your Membership anytime and for any reason, which include but not limited to: breaching the Agreement, conducting unauthorized commercial activity using your Membership and for other reasons stated in Point 5.")?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"Cancellation of Membership")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"If you are not completely satisfied with our Services, you may cancel your Membership anytime. You can either simply cease using the site or send us an e-mail to [insert e-mail address here] with your request. Cancellation of your membership is your sole right and remedy regarding any dispute with Premium Link Generator.")?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"Description of Services")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"Premium Link Generator works like a proxy server so users can download and store legitimate files hosted in third-party cloud services in high-speed and without the need to subscribe. The Site is doing everything to prevent the distribution of copyrighted files by using all available technology and methods, such as:")?>
	            </p>
            </div>
	            <ol>
	            	<li><?= Yii::t('terms',"Name filters. If the file name is subject to intellectual property right then downloading the file is allowed.")?></li>
	            	<li><?= Yii::t('terms',"DMCA File List. Users can store files that were included in the list of Premium Link Generator which violate the DMCA. Note: The Site has a relevant form that members and non-members can use to report these kinds of files.")?></li>
	            	<li><?= Yii::t('terms',"When Premium Link Generator receives a DMCA complaint or detects that a file is subject to copyright, the Site immediately notifies the cloud service where it is stored. The file will be immediately deleted from the website where it is stored so the distribution and sharing of the file will be impossible.")?></li>
	            </ol>
	            <p class='weigth_normal'>
	            	<?= Yii::t('terms',"There are also other methods that Premium Link Generator uses to prevent the distribution of copyrighted files. However, these can be disclosed publicly so hostile users can\u2019t evade them.Premium Link Generator only operates like a proxy server with private members that can download files. The Site DOES NOT pay anyone to upload or download files. The servers only act as a proxy and DO NOT store any file.")?>
	            </p>
            <div class="b">
            	<?= Yii::t('terms',"Member Content")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"The downloaded files through the Site by members are their responsibility and for any and all succeeding uses of the Generated URLs. Before you post Download Generated URLs, you must be sure that you have all the essential ownership and other rights for these. Users must agree to use the Services in accordance with any and all applicable laws and regulations.Below is the list of things that you shouldn\u2019t do regarding the Generated URLs:")?>
	            </p>
            </div>
	            <ol>
	            	<li><?= Yii::t('terms',"Any content that can be considered to be unlawful, harmful, threatening, defamatory, obscene, harassing, or otherwise objectionable should be downloaded;")?></li>
	            	<li><?= Yii::t('terms',"An account will be immediately terminated if the user downloads any content that violates any trademark, trade name, service mark, copyright license, or other intellectual property, or proprietary right of any third party;")?></li>
	            	<li><?= Yii::t('terms',"Personally identifiable information of any third-person should be downloaded including telephone numbers, street addresses, last names, URLs, and e-mail addresses")?></li>
	            	<li><?= Yii::t('terms',"Without prior authorization, users should download any audio files, text, photographs, videos, and other images containing confidential information")?></li>
	            	<li><?= Yii::t('terms',"Obscene files, which are defined under applicable law, including audio files, text, photographs, or other images should be downloaded")?></li>
	            	<li><?= Yii::t('terms',"Users should never express or imply that any of their statements were endorsed by Premium Link Generator without or specific written consent")?></li>
	            	<li><?= Yii::t('terms',"Without consent, users can collect personal information about end-users or other third parties")?></li>
	            	<li><?= Yii::t('terms',"Users should never retrieve, index, or in any way reproduce or by-pass the navigational structure of the Site, Services, or related content using any robot, spider, site search\/retrieval application, or other manual or automatic device;")?></li>
	            	<li><?= Yii::t('terms',"The Services, the Site, and\/or the server and\/or networks connected should never be interrupted or destroy by the users")?></li>
	            	<li><?= Yii::t('terms',"Software that contains viruses or other computer code, files, or programs designed to disrupt, damage, or limit the functionality of any computer software or hardware or telecommunications equipment should be posted, offer for download, e-mail or otherwise transmit any material")?></li>
	            	<li><?= Yii::t('terms',"Spyware, adware, and other programs designed to send unsolicited advertisements services should be posted, offer for download, transmit, promote, or make available any software, products, or services that are illegal or that violates the rights of a third-party. This software is designed to initiate denial of service attacks, mail bomb programs, and other programs designed to infiltrate access to networks on the internet")?></li>
	            	<li><?= Yii::t('terms',"Any part of the Site and\/or Services should be frame or mirror without Premium Link Generator written consent")?></li>
	            	<li><?= Yii::t('terms',"Immediate account termination and spreading of member details to the authorities will be done in case someone uses our services for content that can be considered abusive to children or illegal pornography")?></li>
	            	<li><?= Yii::t('terms',"Any part of the Site and\/or Service should be modified, adapted, sublicensed, translated, sell, reverse engineer, decipher, decompile, or otherwise disassemble")?></li>
	            	<li><?= Yii::t('terms',"Generated URLs can only be used by the owner of Premium Link Generator account. It not allowed to post or share these with anyone and only works with the account that generated them.If a user was found violating any of these practices, it will be deemed as a breach of the Agreement and the account will be immediately terminated without notice. Premium Link Generator has the right to do any legal action against members that will violate the Member Content section.")?></li>
	            </ol>
            <div class="b">
                  <?= Yii::t('terms',"Non-Endorsement Neutral Party")?></h2>
                  <p class='weigth_normal'>
                  <?= Yii::t('terms',"Premium Link Generator works the Site and Services as a neutral party. Thus, the Site doesn\u2019t regularly monitor, regulate, or watch the use of the Site and or Services by any of its Members. However, it doesn't mean that Premium Link Generator endorse any activity of the Members. The Site is not responsible for the Member or other third-party acts, omissions, agreements, promises, content links, other products, services, comments, opinions, advice, statements, offers, and or other information made available.")?>
                  </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"Proprietary Rights")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"Attempt to damage, destroy, tamper with, vandalize, and or interfere with the operation of the Site and or Services is a violation of criminal and civil law. Premium Link Generator will pursue legal actions against individual or entity to the fullest extent approved by the law and in equity.")?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"Premium Membership Fees")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"When you register for our Premium Services and use any method of payment, your account will be charged the applicable amount based on what you choose. All charges are billed in U.S. Dollars. If members don't want to use Premium Services, it doesn't mean that they refuse to pay any of the fees.")?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"Third Party Websites")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"Premium Link Generator contains a link to other websites on the internet, which are owned and operated by third parties. Note that the inclusion of all these links doesn't imply that the Site endorses these third-party websites or has any association with the website operators. The Site has no control over the information, products, or services on these third-party websites. Thus, users agree that Premium Link Generator can't be held liable or responsible for the availability or the operation of these third-party sites. Any kind of transaction, dealings, participations offered on the advertiser site including payment and delivery of related products or service, or any other terms, conditions, warranties, or representations associated with the transactions are solely between you and the applicable third-party website. Premium Link Generator shall not be responsible, directly or indirectly, for any loss or damages caused by the products or services purchased by the user from any third-party website.")?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"Disclaimer of Warranties")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"BASED FROM THE FULLEST EXTENT PERMITTED BY APPLICABLE LAW (INCLUDING, BUT NOT LIMITED TO, DISCLAIMER OF WARRANTIES OF MERCHANTABILITY, NON-INFRINGEMENT OF INTELLECTUAL PROPERTY, AND OR FITNESS FOR A PARTICULAR PURPOSE), THE SITE, SERVICES, GENERATED URLS, AND\/OR ANY PRODUCTS AND\/OR SERVICES OFFERED ON THE SITE ARE PROVIDED TO USERS ON AN IS AND AVAILABLE. PREMIUM LINK GENERATOR CAN\u2019T GUARANTEE THAT THE SITE, SERVICES, GENERATED URLS, AND\/OR ANY OTHER PRODUCTS AND\/OR SERVICES OFFERED ON THE SITE WILL:")?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"MEET USER'S REQUIREMENTS")?></h2>
            </div>
            <ol>
            	<li><?= Yii::t('terms',"FREE OF VIRUSES OR OTHER HARMFUL CONTENTS")?></li>
            	<li><?= Yii::t('terms',"SECURITY METHODS THAT WILL BE ENOUGH TO PROVIDE ENJOYMENT WITH THE USE OF THE SITE OR FIGHT AGAINST INFRINGEMENT;AND OR")?></li>
            	<li><?= Yii::t('terms',"ACCURATE OR RELIABLE.")?></li>
            </ol>
            <div class="b">
            	<?= Yii::t('terms',"Limitations of Liability")?></h2>
            </div>
            <ol>
            	<li><?= Yii::t('terms',"PREMIUM LINK GENERATOR SHALL NOT BE LIABLE DIRECTLY, INDIRECTLY, INCIDENTALLY, SPECIALLY, CONSEQUENTIALLY, AND\/OR EXEMPLARY TO THE USERS OR ANY THIRD-PARTY FOR ANY DAMAGES, LOSS OF PROFITS, GOODWILL, USE, DATA, OR OTHER INTANGIBLE LOSSES (EVEN IF PREMIUM LINK GENERATOR HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES) TO THE FULLEST EXTENT PERMITTED BY THE LAW FOR:")?></li>
            	<li><?= Yii::t('terms',"THE COST OF OBTAINING SUBSTITUTE GOODS AND SERVICES RESULTING FROM ANY GOODS, DATA, INFORMATION, CONTENT AND\/OR ANY OTHER PRODUCTS PURCHASED OR OBTAINED FROM OR THROUGH THE SITE")?></li>
            	<li><?= Yii::t('terms',"THE UNAUTHORIZED ACCESS TO, OR ALTERATION OF, YOUR REGISTRATION DATA; AND")?></li>
            	<li><?= Yii::t('terms',"ANY OTHER ISSUE INVOLVING TO THE SITE, SERVICES, GENERATED URLS AND\/OR ANY OTHER PRODUCTS AND\/OR SERVICES OFFERED ON THE SITE.")?></li>
            </ol>
            <?= Yii::t('terms',"ALL OF THE LIMITATION STATED APPLIES, BUT NOT LIMITED TO, THE BREACH OF CONTRACT, BREACH OF WARRANTY, NEGLIGENCE, STRICT LIABILITY, MISREPRESENTATION, AND ANY AND ALL OTHER OFFENSES. PREMIUM LINK GENERATOR WILL BE RELEASED FROM ANY AND ALL OBLIGATIONS, LIABILITIES, AND CLAIMS IN EXCESS OF THE LIMITATIONS STATED. AFTER ONE (1) YEAR FOLLOWING THE EVENT, YOU OR THE SITE CAN'T DO ANY ACTION REGARDING THE ISSUE THAT AROSE OUT OF YOUR USE OF THE SITE, SERVICES, GENERATED URLS AND OR ANY OTHER PRODUCTS AND OR SERVICES OFFERED ON THE SITE. WITHOUT THESE LIMITATIONS, THE ACCESS OF THE SITE, SERVICES, GENERATED URLS, AND\/OR ANY OTHER PRODUCTS AND OR SERVICES OFFERED ON THE SITE WILL NOT BE PROVIDED TO USERS. NOTE: SOME JURISDICTIONS DO NOT ALLOW CERTAIN LIMITATIONS ON LIABILITY. THUS, PREMIUM LINK GENERATOR LIABILITY SHALL BE LIMITED TO THE MAXIMUM EXTENT PERMITTED BY THE LAW.")?></h2>
            <div class="b">
            	<?= Yii::t('terms',"Editing, Deleting, and Modification")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"Any content, documents, information, or other materials that can be seen on the Site, can be edited and or deleted with Premium Link Generators right and sole discretion.")?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"User Information")?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"Any of the materials that users submit or associated with the Site including, but not limited to, the Registration Data, shall be subjected to the Privacy Policy. You can read the Privacy Policy using the link below or click here {privacy_link}.",['privacy_link'=>HTML::a('http://premiumlinkgenerator.com/en/privacy-policy','/privacy-policy',['style'=>'color:blue','target'=>'_blank'])])?>
	            </p>
            </div>
            <div class="b">
            	<?= Yii::t('terms',"How to Contact Us",['privacy_link'=>HTML::a('http://premiumlinkgenerator.com/en/privacy-policy','/privacy-policy',['style'=>'color:blue','target'=>'_blank'])])?></h2>
            	<p class='weigth_normal'>
	            <?= Yii::t('terms',"If you have any queries or concerns regarding the Agreement or the methods of Premium Link Generator do not hesitate to contact us here {link} Contact US",['link'=>HTML::a('support@premiumlinkgenerator.com','mailto:support@premiumlinkgenerator.com',['style'=>'color:blue'])])?>
	            </p>
            </div>
		</div>
	</section>
</main>