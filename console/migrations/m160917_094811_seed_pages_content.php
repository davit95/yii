<?php

use yii\db\Migration;

class m160917_094811_seed_pages_content extends Migration
{
    public function up()
    {
        $dmca_data = ["Title1"=>"DMCA","Title2"=>"Copyright Policy",'Text'=>"To users, note that premiumlinkgenerator.com only provides proxy service and not file-hosting. But we do our best to find and delete illegal contents, which are reported by our users. We take copyright violation very seriously and we are committed to protecting the rights of copyright owners. All premiumlinkgenerator.com users are bound by the Terms of Use and the law to respect owners’ rights. Users are not allowed to copy, adapt, distribute, or publicly display or perform works of the original work without the authorization of the respective copyright owner.
        In case you saw something illegal, i.e. persons under the age of 18 in a video or people doing illegal activities, please immediately report it to us by sending the links and file address or number. In the event that you find a content that you own with copyrights and want to remove it, you can simply send us an e-mail at [insert e-mail address here]. Make sure that your message contains the terms ‘dmca’, ‘copyright’, ‘removal’, so we can easily screen it since we are receiving a lot of e-mails.
        We will immediately stop and further prevent copyright violation upon notice. If a user was found to violate Copyright policy, then he/she will face consequences. Premiumlinkgenerator.com follows a three strikes policy. Once we receive a valid notice that a user’s account is disobeying our Copyright Policy, we will immediately disable all access to the material including the user’s access and deactivate the sharing function. The user will be notified through e-mail regarding our actions together with the information that his/her violation has been put on the record for that account under the ‘three-strike’ rule of the Repeat Infringer Termination Policy. The file-sharing function will only be reactivated once the user certifies through an electronic signature option on premiumlinkgenerator.com website that he/she removed all copyright infringing material from his/her account. In the case that the user has violated the Copyright Policy for the third time, the user’s account will be terminated and the user will be permanently banned in premiumlinkgenerator.com."];
            $this->insert('{{%pages}}', [
                'page_name' => 'dmca',
                'content'=>json_encode($dmca_data)
            ]);

            $refund_policy = ["Title1"=>"Refund Policy",'Text'=>"Here in Premium Link Generator, we aim to make sure that our members are satisfied with our services.
            We are confident that everyone will like our downloading service because it is simple and user-friendly. Moreover, we are willing to put our credibility on the line by offering a risk-free money-back guarantee.
            In the event that you are not satisfied with your Premium account, you can ask for a refund in the first 2 days and if you haven’t downloaded more than 8GB or more than 10 different files. However, there are some cases that a customer is not qualified for a refund due to restrictions. In case you are not aware of these limitations, please check them here [insert link for restrictions].
            In your request, you simply need to state the reason why you are not satisfied with our service and the reason for wanting to end your membership. This is very important to us and we take it seriously because we use customers’ feedbacks to continuously develop our services.
            For your questions and queries about the refund and cancellation of your membership, do not hesitate to send your e-mail to [insert e-mail address here]."];
            $this->insert('{{%pages}}', [
                'page_name' => 'refund-policy',
                'content'=>json_encode($refund_policy)
            ]);

        $privacy_policy = ["Title1"=>"Privacy Policy",'Title2'=>"Premium Link Generator Privacy Policy","Text2"=>"Here in premiumlinkgenerator.com, we recognize and respect the privacy of our users over the internet. This page is dedicated to providing information about the privacy and process of collecting data for the site: http://dev.premiumlinkgenerator.com.<br><br>
        The purpose of our website is to provide a platform where users can download files from several hosting websites by using a Premium Link Generator account. Premium Link generator works by linking users with file-sharing networks or online cloud services. The administrators or servers of Premium Link generator has no control over the files stored remotely or the files uploaded by the users. The personal information that you willingly provide to our website is used so you can benefit from our services. If you don’t want to provide such information to us, then you can’t be a member.<br>
        <h6>The Premium Link Generator Site and Third Party Sites</h6>
        This Privacy Policy only applies to Premium Link Generator Site. The links to third party sites that Premium Link Generator may contain are not owned or control by us and we assume no responsibility for its content, privacy policies, or practices. Users agree that they are responsible for reviewing and understanding the privacy policy (if any) of any third party sites that users may access through this Site. When you use this Site, you will not hold Premium Link Generator from any and all liability that may arise from using any third-party site to which this Site may be linked.<br>
        Based on the information that we collect, we use it to provide and improve the Service, the Site, and the related features, to administer users’ subscription and to enable them to enjoy and easily navigate the Site. Below is the list of types and categories of information that our Site collects.<br>","Title3"=>"Personal Information Collected","Text3"=>" Our Site collects the personal information using:<br><br>
        <ul>
        <b><li class = 'circle-li'>Registration</li></b>
        </ul><br>
        You are required to create an account on our Site to become a user. You need to provide contact information including e-mail address and a password, which you recognize and clearly acknowledge as personal information used to identify you. Your account’s password will be sent through the e-mail you provided, which can be changed anytime by logging into your account and editing your ‘My Details’ section.<br><br>
        <ul>
        <b><li class = 'circle-li'>Log Data</li></b>
        </ul><br>
        Simply browsing our server automatically records information about your use of the Site. The Log Data may contain information, such as your IP address, browser type, the software you were using, pages of the Site that you visited, the time spent on those pages, the information you searched on the Site, access times and dates, and other statistics. The information we collect is used to monitor and analyze the use of the Site and the Service, for the Site’s technical administration, to improve Site’s functionality and accessibility, and to customize it depending on our users’ needs.<br><br>
        <ul>
        <b><li class = 'circle-li'>Cookies</li></b>
        </ul><br>
        Premium Link Generator uses cookies and web log files like other websites in order to track site usage. One type of cookie that we are using is known as ‘persistent’ cookie, which allows the Site to recognize you as a user when you return using the same computer and web browser. Thus, you won’t need to log in before using the service. If your browser settings don’t allow cookies, then you won’t be able to login to your Premium Link Generator Premium account. The cookie and log file data is also used to customize your experience on our Site, which is similar to the information that you enter at the registration.<br><br>
        <h6>Log files, IP addresses, and information about your computer</h6>
        When users visit Premium Link Generator site, we automatically receive information from them due to the communications standards on the internet. The information that we receive includes the URL of the site from which users came and the site to which users are going when they leave the Site, IP address of their computer or the proxy server they use to access the internet, their computers operating system and the type of browser they are using, e-mail patterns, and the name of their ISP. The information we received will help us improve the Site’s service by analyzing overall trends. Third parties won’t get any access to users IP address and personally identifiable information without their permission unless it is required by the law.<br><br>",'Title4'=>'Premium Link Generator Communications','Text4'=>'Communication between the Site administrators and users will be through e-mail, notices on the forum site, and other means of services like text and other forms of messaging. To change your e-mail and contact preferences, simply log in to your account and edit ‘My Details’ section.<br><br>','Title5'=>'Sharing Information with Third Parties','Text5'=>'   The Site gives importance to the privacy of our users. Thus, we do not sell, rent, or provide your personally identifiable information to third parties for marketing purposes. We will only do such thing based on your instructions or to provide specific services or information. For example, we use credit card processing companies to charge users for premium accounts. However, these third parties do not retain, share, or store any personally identifiable information except to provide these services. They are obliged by confidentiality agreements that limit their use of such information.<br><br>','Title6'=>'Phishing','Text6'=>'Phishing and identity theft are major concerns on our Site. Thus, protecting our users’ information is our top priority. We do not and will not, at any time, ask for your personal information including credit card information, your account ID, login password using a non-secure or unsolicited e-mail or via phone call.<br><br>','Title7'=>'Links to Other Sites','Text7'=>'You will find third party links in our site but we do not endorse, authorize, or represent any affiliation to these third party websites nor endorse their privacy or information security policies, or practices. We do not control these third party websites. Thus, we encourage our users to read the privacy policies or statements of the other websites you visit. These third party sites may place their own cookies or other files on your computer, collect data or ask personal information from you. They follow different rules regarding the use or disclosure of the personal information you submit to them.<br><br>','Title8'=>'Accessing and Changing your Account Information','Text8'=>' The information that users provided on our Site can be reviewed and changed anytime by simply logging into the user’s account on the Premium Link Generator site. However, even after the user requested for a change is processed, the Site may for a time retain residual information in its backup and/or archival copies of its database.<br><br>','Title9'=>'Deleting your Account','Text9'=>'  Users can easily request to delete their account at any time. Note that Premium Link Generator site may retain certain data contributed by the user, which we believe can be used to prevent fraud or future abuse, legitimate business purposes like analysis of aggregated, non-personally identifiable data, and account recovery, or if required by the law. To delete your account, please send us a request at [insert e-mail address here] and it will be deleted as soon as possible.<br><br>','Title10'=>'Your Obligations','Text10'=>' Users also have certain obligations that are imposed by applicable law and regulations:
        Users must all the time respect the Terms and Conditions of the then-current Privacy Policy and the Terms of Use including all intellectual property rights which may belong to third parties.
        Users must not download or distribute any information which can be considered to be injurious, violent, offensive, racist, or xenophobic.
        We take these principles very seriously and consider these to be the basis on which our users follow to the Premium Link Generator Site and the services we offer. Thus, any violation of these guidelines may lead to the restriction, suspension, or termination of user’s account.<br><br>','Title11'=>'Changes to This Policy','Text11'=>' From time to time, we may revise our privacy policy. Thus, we encourage our users to periodically visit this page to be aware of any such revisions. However, we will not use our users’ existing information in a method not previously disclosed. Users will be advised and given the choice to opt out of any new use of their information.<br><br>','Title12'=>'How to Contact Us','Text12'=>'For any queries or concerns regarding this page, do not hesitate to contact our site coordinator at [insert e-mail address here].'];
            $this->insert('{{%pages}}', [
                'page_name' => 'privacy-policy',
                'content'=>json_encode($privacy_policy)
            ]);
    }

    public function down()
    {

    }

}