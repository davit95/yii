<?php

use yii\db\Migration;

class m161108_155819_seed_testing_translations_for_all_pages extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        //Translation data-testing,words is not correct
        //Trasnlation will by updated dynamicly from admin panel
        $source = [
            //homepage
            ['category' => 'homepage', 'message' => 'Download Everything With One Account'],
            ['category' => 'homepage', 'message' => 'One site. One low price.{tag}{host_number} different file hosts to download from!'],
            ['category' => 'homepage', 'message' => 'Why Premium Link Generator'],
            ['category' => 'homepage', 'message' => 'Join Today and download EVERYTHING from EVERYWHERE'],
            ['category' => 'homepage', 'message' => '{host_number} File Hosts in one Account'],
            ['category' => 'homepage', 'message' => 'Download from everywhere'],
            ['category' => 'homepage', 'message' => 'And more than'],
            ['category' => 'homepage', 'message' => '{host_number} another Hosts'],
            ['category' => 'homepage', 'message' => 'All major hosters supported'],
            ['category' => 'homepage', 'message' => 'Downloading files from Turbobit, Filepost, Extabit, Rapidgator, Uploaded.net and other one-click -hosters? Now you can have them all with one PLG subscription!'],
            ['category' => 'homepage', 'message' => 'Download super-fast'],
            ['category' => 'homepage', 'message' => 'Utilize your max speed'],
            ['category' => 'homepage', 'message' => 'Download any files you want as premium without waiting time, at a very high speed, no matter on which site the files are hosted!'],
            ['category' => 'homepage', 'message' => 'Keep your money in your pocket'],
            ['category' => 'homepage', 'message' => '1 Account, value of 118 FileHosts!'],
            ['category' => 'homepage', 'message' => 'Donâ€™t spend your money on various one click accounts. Downloading does not need to cost you a fortune anymore. All you need is one PLG account and you are 100% covered.'],
            ['category' => 'homepage', 'message' => 'When It Comes To Servers {tag} We Have The Best That Exist!'],
            ['category' => 'homepage', 'message' => 'So you can enjoy super-fast downloading {tag} from {host_number} different file hosts.'],
            ['category' => 'homepage', 'message' => 'Works very easy'],
            ['category' => 'homepage', 'message' => "That's it! {tag} Enjoy your download!"],
            ['category' => 'homepage', 'message' => "Copy Paste your {tag} download link"],
            ['category' => 'homepage', 'message' => "Download the file {tag} at high speed!"],
            ['category' => 'homepage', 'message' => "Let us process the link"],
            ['category' => 'homepage_button', 'message' => "View All File Hosts"],
            ['category' => 'homepage_create_button', 'message' => "Create Account"],
            //how does it works page
            ['category' => 'how_it_works', 'message' => 'How it works'],
            ['category' => 'how_it_works', 'message' => "Forget about downloading delays. No need to wait until the files are downloaded to Zevera’s servers and then to your device, neither. Just add the links of any supported hoster, and downloading starts immediately!"],
            ['category' => 'how_it_works', 'message' => "In order to make your life even more easy, we work with the best Downloader Applications."],
            ['category' => 'how_it_works', 'message' => "The Downloader Applications below optimize your Zevera experience by providing better speeds."],
            ['category' => 'how_it_works', 'message' => "Chose the one you prefer, customize the Settings and enjoy optimum Zevera downloading."],
            ['category' => 'how_it_works', 'message' => "Jet Downloader is a program designed to help you to download content on multiple file hosters and efficiently manage your bandwidth. After you configure your file hosting accounts in the software, you can easily download any content. Jet Downloader supports multi-segments download: it means it downloads multiple parts of your files at the same time and then join them together. It allows you to have better download speed with no inconveniences."],
            ['category' => 'how_it_works', 'message' => "JDownloader is a free, open-source download management tool with a huge community of developers that makes downloading as easy and fast as it should be. Users can start, stop or pause downloads, set bandwith limitations, auto-extract archives and much more. It's an easy-to-extend framework that can save hours of your valuable time every day!"],
            ['category' => 'how_it_works', 'message' => 'Download the file {tag} {span} copy it into your {tag} download accelerator'],
            ['category' => 'how_it_works', 'message' => '{div} Generate PLG Link'],
            ['category' => 'how_it_works', 'message' => 'Paste links {div}'],
            //supported file hosts
            ['category' => 'hosts', 'message' => 'Supported File Hosts'],
            ['category' => 'hosts', 'message' => 'The list below is our whole pride! The zevera.com supported hosters- brought to you all with the price of one premium account! You are literally a few steps away from downloading as premium from all of the below supported one click hosters! And of course we are constantly adding new hosters once they become popular. As a matter of fact if you have a special hoster request please don’t hesitate to let us know!'],
            ['category' => 'hosts', 'message' => 'Join Today and download EVERYTHING from EVERYWHERE {tag} {host_number} File Hosts in one Account'],
            ['category' => 'hosts_button', 'message' => 'Upgrade Account'],
            ['category' => 'hosts', 'message' => '{host_number} File Hosts'],
            //uptime & overview
            ['category' => 'uptime_and_overview', 'message' => 'Uptime and Overview'],
            ['category' => 'uptime_and_overview', 'message' => 'Because transparency metters, here is a live status of hosts availability'],
            ['category' => 'uptime_and_overview', 'message' => 'From our wild imaginationâ€¦ We acknowledged that the clouds are the future, but saw much more potential in them. When everybody was just storing files in their online drives, synching them with their mobiles and sharing them with others, we imagined something that would push this cloud experience to a whole other Level. Something like a â€œGenius Servantâ€, â€œa Wizâ€, a â€œBrilliant Secretaryâ€ that would work for you: interconnect all your clouds so you would have endless storage space and one window simplicity! We knew what we wanted and how to execute it...'],
            //price page
            ['category' => 'price', 'message' => 'Why Upgrade Account'],
            ['category' => 'price', 'message' => 'Premium Downloading {tag} from 120 File-Hosters'],
            ['category' => 'price', 'message' => 'No other site supports so many File Hosts! Download from Turbobit, Filepost, Extabit, Rapidgator, Uploaded.net and so many more with the price of one!'],
            ['category' => 'price', 'message' => 'No daily limits on {tag} Download'],
            ['category' => 'price', 'message' => 'Download as much as you want ignoring form which file hoster it is, without worrying about daily limits and while saving money at the same time!'],
            ['category' => 'price', 'message' => 'Unlimited parallel {tag} Downloads'],
            ['category' => 'price', 'message' => 'Our Premium users can download as many files as they want at the same time!'],
            ['category' => 'price', 'message' => 'Money-back {tag} Guarantee'],
            ['category' => 'price', 'message' => 'In the rare case you stay unsatisfied by our services Premium Link Generator offers you a full- money- back guarantee!'],
            ['category' => 'price', 'message' => 'Choose Your Plan'],
            ['category' => 'price', 'message' => 'Not a fan of subscriptions? {tag} Choose the gigabytes package that suits you best without expiry date!'],
            ['category' => 'price', 'message' => 'Try 7 Free-trial days'],
            ['category' => 'price', 'message' => 'We offer you 7 free-trial days when registered to help you form your opinion about our services.'],
            ['category' => 'price', 'message' => 'This offer is restricted to new members only {tag} 10 Gb download limit per day'],
            ['category' => 'price', 'message' => 'We Accept'],
            ['category' => 'price', 'message' => '100% Security Guarantee'],
            ['category' => 'price', 'message' => 'All your payments are carried out via'],
            ['category' => 'price', 'message' => 'very reliable third-party companies'],
            ['category' => 'price', 'message' => 'Safety is out Nr1 Priority'],
            ['category' => 'price', 'message' => 'All transactions are carried out in an'],
            ['category' => 'price', 'message' => 'absolutely safe environment'],
            ['category' => 'price', 'message' => 'Anonymity is guaranteed'],
            ['category' => 'price', 'message' => 'All your data stays unknown!'],
            ['category' => 'price', 'message' => 'Nobody will ever know your'],
            ['category' => 'price', 'message' => 'payment details'],
            ['category' => 'price', 'message' => 'Most popular'],
            ['category' => 'price', 'message' => '87% of customers choose'],
            ['category' => 'price_button', 'message' => 'Create Account'],
            ['category' => 'price_button', 'message' => 'Supported File Hosts'],
            //about us page
            ['category' => 'about_us', 'message' => 'About us'],
            ['category' => 'about_us', 'message' => 'It all started from our wild imagination… '],
            ['category' => 'about_us', 'message' => 'We acknowledged that the clouds are the future, but saw much more potential in them. When everybody was just storing files in their online drives, synching them with their mobiles and sharing them with others, we imagined something that would push this cloud experience to a whole other Level. Something like a Genius Servant that would work for you: interconnect all your clouds so you would have endless storage space and one window simplicity!'],
            ['category' => 'about_us_vision', 'message' => 'Our vision'],
            ['category' => 'about_us', 'message' => 'Was to change the way people work, store and download! We basically wanted to create a service that is user friendly, inexpensive and smart. In other words: we tried to reinvent, redefine and upgrade the whole experience you, the user, have with clouds. We wanted to give the user the Benefit of Simplicity: to access all their clouds with one Account!'],
            ['category' => 'about_us', 'message' => 'Our staff'],
            ['category' => 'about_us', 'message' => 'as a very committed group of highly qualified specialists in the field of programming, web-design and marketing. All of them share the same values of building advanced software that will make people’s lives easier. Our main principle is simply to create great software, satisfying the needs of the Internet users.'],
            ['category' => 'about_us', 'message' => 'Still have a question? Feel free to contact us!'],
            ['category' => 'about_us', 'message' => 'Contact Us'],

            //dmca page
            ['category' => 'dmca', 'message' => 'Dmca'],
            ['category' => 'dmca', 'message' => 'Copyright Policy'],
            ['category' => 'dmca', 'message' => 'To users, note that {link} only provides proxy service and not file-hosting. But we do our best to find and delete illegal contents, which are reported by our users. We take copyright violation very seriously and we are committed to protecting the rights of copyright owners. All premiumlinkgenerator.com users are bound by the Terms of Use and the law to respect owners’ rights. Users are not allowed to copy, adapt, distribute, or publicly display or perform works of the original work without the authorization of the respective copyright owner.In case you saw something illegal, i.e. persons under the age of 18 in a video or people doing illegal activities, please immediately report it to us by sending the links and file address or number. In the event that you find a content that you own with copyrights and want to remove it, you can simply send us an e-mail at [insert e-mail address here]. Make sure that your message contains the terms "dmca", "copyright", "removal", so we can easily screen it since we are receiving a lot of e-mails.We will immediately stop and further prevent copyright violation upon notice. If a user was found to violate Copyright policy, then he/she will face consequences. {link} follows a three strikes policy. Once we receive a valid notice that a user’s account is disobeying our Copyright Policy, we will immediately disable all access to the material including the user’s access and deactivate the sharing function. The user will be notified through e-mail regarding our actions together with the information that his/her violation has been put on the record for that account under the ‘three-strike’ rule of the Repeat Infringer Termination Policy. The file-sharing function will only be reactivated once the user certifies through an electronic signature option on {link} website that he/she removed all copyright infringing material from his/her account. In the case that the user has violated the Copyright Policy for the third time, the user’s account will be terminated and the user will be permanently banned in {link}'],
            //refund-policy page
            ['category' => 'dmca', 'message' => 'Refund Policy'],
            ['category' => 'dmca', 'message' => 'Here in Premium Link Generator, we aim to make sure that our members are satisfied with our services.We are confident that everyone will like our downloading service because it is simple and user-friendly. Moreover, we are willing to put our credibility on the line by offering a risk-free money-back guarantee.In the event that you are not satisfied with your Premium account, you can ask for a refund in the first 2 days and if you haven’t downloaded more than 8GB or more than 10 different files. However, there are some cases that a customer is not qualified for a refund due to restrictions. In case you are not aware of these limitations, please check them here [privacy-policy].In your request, you simply need to state the reason why you are not satisfied with our service and the reason for wanting to end your membership. This is very important to us and we take it seriously because we use customers’ feedbacks to continuously develop our services.For your questions and queries about the refund and cancellation of your membership, do not hesitate to send your e-mail to {support}'],

            //privacy-policy page
            ['category' => 'privacy_policy', 'message' => 'Privacy Policy'],
            ['category' => 'privacy_policy', 'message' => 'Premium Link Generator Privacy Policy'],
            ['category' => 'privacy_policy', 'message' => 'Here in {link}, we recognize and respect the privacy of our users over the internet. This page is dedicated to providing information about the privacy and process of collecting data for the site: {link}'],
            ['category' => 'privacy_policy', 'message' => 'The purpose of our website is to provide a platform where users can download files from several hosting websites by using a Premium Link Generator account. Premium Link generator works by linking users with file-sharing networks or online cloud services. The administrators or servers of Premium Link generator has no control over the files stored remotely or the files uploaded by the users. The personal information that you willingly provide to our website is used so you can benefit from our services. If you don’t want to provide such information to us, then you can’t be a member.'],
            ['category' => 'privacy_policy', 'message' => 'The Premium Link Generator Site and Third Party Sites'],
            ['category' => 'privacy_policy', 'message' => 'This Privacy Policy only applies to Premium Link Generator Site. The links to third party sites that Premium Link Generator may contain are not owned or control by us and we assume no responsibility for its content, privacy policies, or practices. Users agree that they are responsible for reviewing and understanding the privacy policy (if any) of any third party sites that users may access through this Site. When you use this Site, you will not hold Premium Link Generator from any and all liability that may arise from using any third-party site to which this Site may be linked.<br>Based on the information that we collect, we use it to provide and improve the Service, the Site, and the related features, to administer users subscription and to enable them to enjoy and easily navigate the Site. Below is the list of types and categories of information that our Site collects.'],
            ['category' => 'privacy_policy_t', 'message' => 'Our Site collects the personal information using:'],
            ['category' => 'privacy_policy', 'message' => 'Registration'],
            ['category' => 'privacy_policy', 'message' => 'You are required to create an account on our Site to become a user. You need to provide contact information including e-mail address and a password, which you recognize and clearly acknowledge as personal information used to identify you. Your account’s password will be sent through the e-mail you provided, which can be changed anytime by logging into your account and editing your ‘My Details’ section.'],
            ['category' => 'privacy_policy', 'message' => 'Log Data'],
            ['category' => 'privacy_policy', 'message' => 'Simply browsing our server automatically records information about your use of the Site. The Log Data may contain information, such as your IP address, browser type, the software you were using, pages of the Site that you visited, the time spent on those pages, the information you searched on the Site, access times and dates, and other statistics. The information we collect is used to monitor and analyze the use of the Site and the Service, for the Site’s technical administration, to improve Site’s functionality and accessibility, and to customize it depending on our users’ needs.'],
            ['category' => 'privacy_policy', 'message' => 'Cookies'],
            ['category' => 'privacy_policy', 'message' => 'Premium Link Generator uses cookies and web log files like other websites in order to track site usage. One type of cookie that we are using is known as ‘persistent’ cookie, which allows the Site to recognize you as a user when you return using the same computer and web browser. Thus, you won’t need to log in before using the service. If your browser settings don’t allow cookies, then you won’t be able to login to your Premium Link Generator Premium account. The cookie and log file data is also used to customize your experience on our Site, which is similar to the information that you enter at the registration.'],
            ['category' => 'privacy_policy', 'message' => 'Log files, IP addresses, and information about your computer'],
            ['category' => 'privacy_policy', 'message' => 'When users visit Premium Link Generator site, we automatically receive information from them due to the communications standards on the internet. The information that we receive includes the URL of the site from which users came and the site to which users are going when they leave the Site, IP address of their computer or the proxy server they use to access the internet, their computers operating system and the type of browser they are using, e-mail patterns, and the name of their ISP. The information we received will help us improve the Site’s service by analyzing overall trends. Third parties won’t get any access to users IP address and personally identifiable information without their permission unless it is required by the law.'],
            ['category' => 'privacy_policy', 'message' =>'Premium Link Generator Communications'],
            ['category' => 'privacy_policy', 'message' => 'Communication between the Site administrators and users will be through e-mail, notices on the forum site, and other means of services like text and other forms of messaging. To change your e-mail and contact preferences, simply log in to your account and edit ‘My Details’ section.'],
            ['category'=>'privacy_policy','message'=>'Sharing Information with Third Parties'],
            ['category' => 'privacy_policy', 'message' => 'The Site gives importance to the privacy of our users. Thus, we do not sell, rent, or provide your personally identifiable information to third parties for marketing purposes. We will only do such thing based on your instructions or to provide specific services or information. For example, we use credit card processing companies to charge users for premium accounts. However, these third parties do not retain, share, or store any personally identifiable information except to provide these services. They are obliged by confidentiality agreements that limit their use of such information.'],
            ['category' => 'privacy_policy', 'message' => 'Phishing'],
            ['category' => 'privacy_policy', 'message' => 'Phishing and identity theft are major concerns on our Site. Thus, protecting our users’ information is our top priority. We do not and will not, at any time, ask for your personal information including credit card information, your account ID, login password using a non-secure or unsolicited e-mail or via phone call.'],
            ['category'=>'privacy_policy','message'=>'Links to Other Sites'],
            ['category' => 'privacy_policy', 'message' => 'You will find third party links in our site but we do not endorse, authorize, or represent any affiliation to these third party websites nor endorse their privacy or information security policies, or practices. We do not control these third party websites. Thus, we encourage our users to read the privacy policies or statements of the other websites you visit. These third party sites may place their own cookies or other files on your computer, collect data or ask personal information from you. They follow different rules regarding the use or disclosure of the personal information you submit to them.'],
            ['category' => 'privacy_policy', 'message' => 'Accessing and Changing your Account Information'],
            ['category' => 'privacy_policy', 'message' => 'The information that users provided on our Site can be reviewed and changed anytime by simply logging into the user’s account on the Premium Link Generator site. However, even after the user requested for a change is processed, the Site may for a time retain residual information in its backup and/or archival copies of its database.'],
            ['category' => 'privacy_policy', 'message' => 'Deleting your Account'],
            ['category' => 'privacy_policy', 'message' => 'Users can easily request to delete their account at any time. Note that Premium Link Generator site may retain certain data contributed by the user, which we believe can be used to prevent fraud or future abuse, legitimate business purposes like analysis of aggregated, non-personally identifiable data, and account recovery, or if required by the law. To delete your account, please send us a request at {support} and it will be deleted as soon as possible.'],
            ['category' => 'privacy_policy', 'message' => 'Your Obligations'],
            ['category' => 'privacy_policy', 'message' => 'Users also have certain obligations that are imposed by applicable law and regulations:Users must all the time respect the Terms and Conditions of the then-current Privacy Policy and the Terms of Use including all intellectual property rights which may belong to third parties.Users must not download or distribute any information which can be considered to be injurious, violent, offensive, racist, or xenophobic.We take these principles very seriously and consider these to be the basis on which our users follow to the Premium Link Generator Site and the services we offer. Thus, any violation of these guidelines may lead to the restriction, suspension, or termination of user’s account.'],
            ['category' => 'privacy_policy', 'message' => 'Changes to This Policy'],
            ['category' => 'privacy_policy', 'message' => 'From time to time, we may revise our privacy policy. Thus, we encourage our users to periodically visit this page to be aware of any such revisions. However, we will not use our users’ existing information in a method not previously disclosed. Users will be advised and given the choice to opt out of any new use of their information.'],
            ['category' => 'privacy_policy', 'message' => 'How to Contact Us'],
            ['category' => 'privacy_policy', 'message' => 'For any queries or concerns regarding this page, do not hesitate to contact our site coordinator at {support}'],
        ];

        $source_translations = [
            //homepage
            [
                ['language' => 'ru', 'translation' => 'Скачать все с одним аккаунтом'],
                ['language' => 'en', 'translation' => 'Download Everything With One Account'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Один сайт. Одна низкая цена.{tag}{host_number} различных хостов файл для загрузки из!'],
                ['language' => 'en', 'translation' => 'One site. One low price.{tag}{host_number} different file hosts to download from!'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Почему генератор премиум Link'],
                ['language' => 'en', 'translation' => 'Why Premium Link Generator'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Присоединяйтесь сегодня и скачать ВСЁ из ВЕЗДЕ'],
                ['language' => 'en', 'translation' => 'Join Today and download EVERYTHING from EVERYWHERE'],
            ],
            [
                ['language' => 'ru', 'translation' => '{host_number} Файл Hosts на одном счете'],
                ['language' => 'en', 'translation' => '{host_number} File Hosts in one Account'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Скачать отовсюду'],
                ['language' => 'en','translation'=>'Download from everywhere'],
            ],
            [
                ['language' => 'ru', 'translation' => 'И больше'],
                ['language' => 'en','translation'=>'And more than'],
            ],
            [
                ['language' => 'ru', 'translation' => '{host_number} еще хосты'],
                ['language' => 'en','translation'=>'{host_number} another Hosts'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Поддерживаются все основные узлы'],
                ['language' => 'en','translation'=>'All major hosters supported'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Загрузка файлов из Turbobit, Filepost, Extabit, Rapidgator, Uploaded.net и других одним нажатием кнопки -hosters? Теперь вы можете иметь их все с одной подписки PLG!'],
                ['language' => 'en','translation'=>'Downloading files from Turbobit, Filepost, Extabit, Rapidgator, Uploaded.net and other one-click -hosters? Now you can have them all with one PLG subscription!'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Скачать сверхбыстрый'],
                ['language' => 'en','translation'=>'Download super-fast'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Используйте вашу скорость макс'],
                ['language' => 'en','translation'=>'Utilize your max speed'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Скачать все файлы, которые вы хотите в качестве премии, не дожидаясь времени, на очень высокой скорости, независимо от того, на каком сайте файлы размещены!'],
                ['language' => 'en','translation'=>'Download any files you want as premium without waiting time, at a very high speed, no matter on which site the files are hosted!'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Храните деньги в кармане'],
                ['language' => 'en','translation'=>'Keep your money in your pocket'],
            ],
            [
                ['language' => 'ru', 'translation' => '1 Счет, стоимость 118 FileHosts!'],
                ['language' => 'en','translation'=>'1 Account, value of 118 FileHosts!'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Возлюбленная € ™ т тратить деньги на различные счета одним щелчком мыши. Загрузка не должна стоить вам счастье больше. Все, что вам нужно, это один счет ПЛГ и вы на 100% охвачены.'],
                ['language' => 'en','translation'=>'Donâ€™t spend your money on various one click accounts. Downloading does not need to cost you a fortune anymore. All you need is one PLG account and you are 100% covered.'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Когда дело доходит до серверов {tag} У нас есть лучшее, что есть!'],
                ['language' => 'en','translation'=>'When It Comes To Servers {tag} We Have The Best That Exist!'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Таким образом, вы можете наслаждаться супер-быстрое скачивание {tag} от {host_number} различных файлообменников.'],
                ['language' => 'en','translation'=>'So you can enjoy super-fast downloading {tag} from {host_number} different file hosts.'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Работает очень легко'],
                ['language' => 'en','translation'=>'Works very easy'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Это оно! {tag} Приятного скачивания!'],
                ['language' => 'en','translation'=>"That's it! {tag} Enjoy your download!"],
            ],
            [
                ['language' => 'ru', 'translation' => 'Скопируйте и вставьте ваш {tag} скачать ссылку'],
                ['language' => 'en','translation'=>"Copy Paste your {tag} download link"],
            ],
            [
                ['language' => 'ru', 'translation' => 'Скачать файл {tag} на высокой скорости!'],
                ['language' => 'en','translation'=>"Download the file {tag} at high speed!"],
            ],
            [
                ['language' => 'ru', 'translation' => 'Давайте обрабатывать ссылку'],
                ['language' => 'en','translation'=>"Let us process the link"],
            ],
            [
                ['language' => 'ru', 'translation' => 'Все файлообменники'],
                ['language' => 'en','translation'=>"View All File Hosts"],
            ],
            [
                ['language' => 'ru', 'translation' => 'Регистрация'],
                ['language' => 'en','translation'=>"Create Account"],
            ],
            //how does it works page
            [
                ['language' => 'ru', 'translation' => 'Как это работает'],
                ['language' => 'en','translation'=>"How it works"],
            ],
            [
                ['language' => 'ru', 'translation' => 'Забудьте о загрузке задержек. Нет необходимости ждать, пока файлы не будут загружены на сервер Zevera, а затем к устройству, ни. Просто добавьте ссылки на любой из поддерживаемых хостером, и загрузка начинается сразу!'],
                ['language' => 'en','translation'=>"Forget about downloading delays. No need to wait until the files are downloaded to Zevera’s servers and then to your device, neither. Just add the links of any supported hoster, and downloading starts immediately!"],
            ],
            [
                ['language' => 'ru', 'translation' => 'Для того, чтобы сделать вашу жизнь еще более легким, мы работаем с лучшими Downloader приложений.'],
                ['language' => 'en','translation'=>"In order to make your life even more easy, we work with the best Downloader Applications."],
            ],
            [
                ['language' => 'ru', 'translation' => 'Загрузчик Приложения ниже оптимизировать свой опыт Zevera, обеспечивая лучшие скорости.'],
                ['language' => 'en','translation'=>"The Downloader Applications below optimize your Zevera experience by providing better speeds."],
            ],
            [
                ['language' => 'ru', 'translation' => 'Выберите тот, который вы предпочитаете, настроить параметры и наслаждаться оптимальной Zevera загрузки.'],
                ['language' => 'en','translation'=>"Chose the one you prefer, customize the Settings and enjoy optimum Zevera downloading."],
            ],
            [
                ['language' => 'ru', 'translation' => 'Jet Downloader это программа, предназначенная, чтобы помочь вам для загрузки контента на нескольких хостеров файлов и эффективно управлять полосой пропускания. После настройки учетных записей хостинга файлов в программном обеспечении, вы можете легко загрузить любой контент. Jet Downloader поддерживает несколько сегментов загрузки: это означает, что он загружает несколько частей файлов одновременно, а затем соединить их вместе. Это позволяет иметь лучшую скорость загрузки без каких-либо неудобств.'],
                ['language' => 'en','translation'=>"Jet Downloader is a program designed to help you to download content on multiple file hosters and efficiently manage your bandwidth. After you configure your file hosting accounts in the software, you can easily download any content. Jet Downloader supports multi-segments download: it means it downloads multiple parts of your files at the same time and then join them together. It allows you to have better download speed with no inconveniences."],
            ],
            [
                ['language' => 'ru', 'translation' => 'JDownloader является свободным, открытым исходным кодом инструмент управления загрузки с огромным сообществом разработчиков, что делает загрузку так же легко и быстро, как это должно быть. Пользователи могут запускать, останавливать или приостанавливать загрузку, установить ограничения Bandwith, автоматически распаковывать архивы и многое другое. Это простой в расширить рамки, которые могут сэкономить часы вашего драгоценного времени каждый день!'],
                ['language' => 'en','translation'=>"JDownloader is a free, open-source download management tool with a huge community of developers that makes downloading as easy and fast as it should be. Users can start, stop or pause downloads, set bandwith limitations, auto-extract archives and much more. It's an easy-to-extend framework that can save hours of your valuable time every day!"],
            ],
            [
                ['language' => 'ru', 'translation' => 'Скачать файл {tag} {span} поверочного скопируйте его в {tag} ускоритель загрузки'],
                ['language' => 'en','translation'=>"Download the file {tag} {span} copy it into your {tag} download accelerator"],  
            ],
            [
                ['language' => 'ru', 'translation' => '{div} Сформировать plg ссылку '],
                ['language' => 'en','translation'=>"{div} Generate PLG Link"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Вставить ссылки {div}'],
                ['language' => 'en','translation'=>"Paste links {div}"],  
            ],
            //supported file hosts
            [
                ['language' => 'ru', 'translation' => 'Поддерживаемые файлообменников'],
                ['language' => 'en','translation'=>"Supported File Hosts"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Приведенный ниже список вся наша гордость! Zevera.com поддержали hosters- принес вам всем с ценой одного премиум аккаунта! Вы буквально в нескольких шагах от загрузки, как премии от всех ниже поддерживаемых одним щелчком мыши хостеров! И, конечно, мы постоянно добавляем новые хостеры, как только они становятся популярными. В самом деле, если у вас есть специальный запрос хостера, пожалуйста, не стесняйтесь, дайте нам знать!'],
                ['language' => 'en','translation'=>"The list below is our whole pride! The zevera.com supported hosters- brought to you all with the price of one premium account! You are literally a few steps away from downloading as premium from all of the below supported one click hosters! And of course we are constantly adding new hosters once they become popular. As a matter of fact if you have a special hoster request please don’t hesitate to let us know!"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Присоединяйтесь сегодня и скачать ВСЁ Отовсюду Хосты {tag} {host_number} файлов в один аккаунт'],
                ['language' => 'en','translation'=>"Join Today and download EVERYTHING from EVERYWHERE {tag} {host_number} File Hosts in one Account"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Обновить аккаунт'],
                ['language' => 'en','translation'=>"Upgrade Account"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'все {host_number} файлообменники'],
                ['language' => 'en','translation'=>"{host_number} File Hosts"],  
            ],
            //uptime & overview
            [
                ['language' => 'ru', 'translation' => 'Провел и Обзор'],
                ['language' => 'en','translation'=>"Uptime and Overview"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Из-за вопросов прозрачности, вот живой статус доступности хостов'],
                ['language' => 'en','translation'=>"Because transparency metters, here is a live status of hosts availability"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'От наших диких imaginationâ € | Мы признали, что облака будущее, но видел гораздо больший потенциал в них. Когда все было просто хранить файлы в своих интернет-дисках, синхронизирование их с их мобильных телефонов и делиться ими с другими, мы представляли себе то, что будет толкать это облако опыт целый другой уровень. Что-то вроде â € œGenius Servantâ € ??, â € œa Wiza € ??, А € œBrilliant Secretaryâ € ?? что будет работать для вас: соединить все ваши облака, чтобы вы имели бы бесконечное пространство для хранения и одно окно простота! Мы знали, что мы хотели и как выполнить его ...'],
                ['language' => 'en','translation'=>"From our wild imaginationâ€¦ We acknowledged that the clouds are the future, but saw much more potential in them. When everybody was just storing files in their online drives, synching them with their mobiles and sharing them with others, we imagined something that would push this cloud experience to a whole other Level. Something like a â€œGenius Servantâ€, â€œa Wizâ€, a â€œBrilliant Secretaryâ€ that would work for you: interconnect all your clouds so you would have endless storage space and one window simplicity! We knew what we wanted and how to execute it..."],  
            ],
            //price page
            [
                ['language' => 'ru', 'translation' => 'Почему обновления аккаунта'],
                ['language' => 'en','translation'=>"Why Upgrade Account"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Премиум Загрузка {tag} из 120 File-хостеров'],
                ['language' => 'en','translation'=>"Premium Downloading {tag} from 120 File-Hosters"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Ни один другой сайт не поддерживает так много файлообменников! Скачать с Turbobit, Filepost, Extabit, Rapidgator, Uploaded.net и так много больше с ценой одного!'],
                ['language' => 'en','translation'=>"No other site supports so many File Hosts! Download from Turbobit, Filepost, Extabit, Rapidgator, Uploaded.net and so many more with the price of one!"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Нет ежедневных ограничений на {tag} Скачать'],
                ['language' => 'en','translation'=>"No daily limits on {tag} Download"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Скачать столько, сколько вы хотите, игнорируя форму, какой файл хостер это, не беспокоясь о ежедневных ограничений и экономя при этом деньги в то же время!'],
                ['language' => 'en','translation'=>"Download as much as you want ignoring form which file hoster it is, without worrying about daily limits and while saving money at the same time!"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Неограниченный параллельные {tag} Загрузки'],
                ['language' => 'en','translation'=>"Unlimited parallel {tag} Downloads"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Наши пользователи Премиум можете скачать столько файлов, сколько они хотят, в то же время!'],
                ['language' => 'en','translation'=>"Our Premium users can download as many files as they want at the same time!"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Возврата денег {tag} Гарантия'],
                ['language' => 'en','translation'=>"Money-back {tag} Guarantee"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'В редком случае вы останетесь довольны нашими услугами премиум Link Generator предлагает Вам гарантию полный- обратно с отмыванием!'],
                ['language' => 'en','translation'=>"In the rare case you stay unsatisfied by our services Premium Link Generator offers you a full- money- back guarantee!"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Выберите свой план'],
                ['language' => 'en','translation'=>"Choose Your Plan"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Не поклонник подписки? {tag} Выберите пакет гигабайта, который подходит вам лучше всего без истечения срока годности!'],
                ['language' => 'en','translation'=>"Not a fan of subscriptions? {tag} Choose the gigabytes package that suits you best without expiry date!"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Попробуйте 7-Free пробные дни'],
                ['language' => 'en','translation'=>"Try 7 Free-trial days"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Мы предлагаем вам 7 свободных дней судебных заседаний при регистрации, чтобы помочь вам сформировать свое мнение о наших услугах.'],
                ['language' => 'en','translation'=>"We offer you 7 free-trial days when registered to help you form your opinion about our services."],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Это предложение ограничено для новых членов только {tag} 10 Gb Предел загрузки в день'],
                ['language' => 'en','translation'=>"This offer is restricted to new members only {tag} 10 Gb download limit per day"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Мы принимаем'],
                ['language' => 'en','translation'=>"We Accept"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Гарантия безопасности 100%'],
                ['language' => 'en','translation'=>"100% Security Guarantee"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Все платежи осуществляются через'],
                ['language' => 'en','translation'=>"All your payments are carried out via"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'очень надежные сторонние компании'],
                ['language' => 'en','translation'=>"very reliable third-party companies"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Безопасность из Nr1 Приоритет'],
                ['language' => 'en','translation'=>"Safety is out Nr1 Priority"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Все операции осуществляют в'],
                ['language' => 'en','translation'=>"All transactions are carried out in an"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'абсолютно безопасная окружающая среда'],
                ['language' => 'en','translation'=>"absolutely safe environment"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Анонимность гарантируется'],
                ['language' => 'en','translation'=>"Anonymity is guaranteed"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Все ваши данные говорит неизвестно!'],
                ['language' => 'en','translation'=>"All your data stays unknown!"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Никто никогда не узнает ваш'],
                ['language' => 'en','translation'=>"Nobody will ever know your"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Детали оплаты'],
                ['language' => 'en','translation'=>"payment details"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Самый популярный'],
                ['language' => 'en','translation'=>"Most popular"],  
            ],
            [
                ['language' => 'ru', 'translation' => '87% клиентов выбирают'],
                ['language' => 'en','translation'=>"87% of customers choose"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Регистрация'],
                ['language' => 'en','translation'=>"Create Account"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'файлообменники'],
                ['language' => 'en','translation'=>"Supported File Hosts"],  
            ],
            //about us page
            [
                ['language' => 'ru', 'translation' => 'О нас'],
                ['language' => 'en','translation'=>"About us"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Все началось с нашего дикого воображения ...'],
                ['language' => 'en','translation'=>"It all started from our wild imagination… "],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Мы признали, что облака будущее, но видел гораздо больший потенциал в них. Когда все было просто хранить файлы в своих интернет-дисках, синхронизирование их с их мобильных телефонов и делиться ими с другими, мы представляли себе то, что будет толкать это облако опыт целый другой уровень. Что-то вроде Genius Слуга, который будет работать для вас: соединить все ваши облака, чтобы вы имели бы бесконечное пространство для хранения и одно окно простота!'],
                ['language' => 'en','translation'=>"We acknowledged that the clouds are the future, but saw much more potential in them. When everybody was just storing files in their online drives, synching them with their mobiles and sharing them with others, we imagined something that would push this cloud experience to a whole other Level. Something like a Genius Servant that would work for you: interconnect all your clouds so you would have endless storage space and one window simplicity!"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Наше видение'],
                ['language' => 'en','translation'=>"Our vision"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Был изменить способ работы людей, магазин и скачать! Мы в основном хотели создать сервис, который является дружественным к пользователю, недорогой и умный. Другими словами: мы пытались изобрести, пересмотреть и обновить весь опыт, который вы, пользователь, иметь с облаками. Мы хотели дать пользователю в пользу Простота: чтобы получить доступ ко всем их облака с одним аккаунтом!'],
                ['language' => 'en','translation'=>"Was to change the way people work, store and download! We basically wanted to create a service that is user friendly, inexpensive and smart. In other words: we tried to reinvent, redefine and upgrade the whole experience you, the user, have with clouds. We wanted to give the user the Benefit of Simplicity: to access all their clouds with one Account!"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Наш персонал'],
                ['language' => 'en','translation'=>"Our staff"],  
            ],
            [
                ['language' => 'ru', 'translation' => 'как очень совершенные группой высококвалифицированных специалистов в области программирования, веб-дизайна и маркетинга. Все они разделяют те же ценности построения современного программного обеспечения, которое сделает жизнь людей легче. Наш основной принцип заключается в создании такого большое программное обеспечение, удовлетворение потребностей пользователей Интернета.'],
                ['language' => 'en','translation'=>"as a very committed group of highly qualified specialists in the field of programming, web-design and marketing. All of them share the same values of building advanced software that will make people’s lives easier. Our main principle is simply to create great software, satisfying the needs of the Internet users."],  
            ],
            [
                ['language' => 'ru', 'translation' => 'Тем не менее есть вопрос? Не стесняйтесь связаться с нами!'],
                ['language' => 'en','translation'=>"Still have a question? Feel free to contact us!"],  
            ],
            [
                ['language' => 'ru','translation' =>'Свяжитесь с нами'],
                ['language' => 'en','translation' =>'Contact Us'],
            ],
            //Dmca page
            [
                ['language' => 'ru','translation' =>'Закон об авторском праве'],
                ['language' => 'en','translation' =>'Dmca'],
            ],
            [
                ['language' => 'ru','translation' =>'Политика защиты авторских прав'],
                ['language' => 'en','translation' =>'Copyright Policy'],
            ],
            [
                ['language' => 'ru','translation' =>'Для пользователей, обратите внимание, что {link} только предоставляет прокси-сервис, а не файл-хостинг. Но мы делаем все возможное, чтобы найти и удалить незаконное содержание, которые сообщили нашими пользователями. Мы принимаем нарушение авторских прав очень серьезно, и мы привержены защите прав владельцев авторских прав. Все пользователи premiumlinkgenerator.com связаны с Условиями использования и законом уважать права владельцев. Пользователям не разрешается копировать, адаптировать, распространять или публично демонстрировать или выполнять работы оригинальной работы без разрешения соответствующего авторского права owner.In случае вы видели что-то незаконное, то есть лиц в возрасте до 18 лет в видео или людей делают незаконной деятельности, пожалуйста, немедленно сообщите нам об этом, отправив ссылки и адрес файла или номер. В случае, если вы нашли содержание, которое вы владеете с авторскими правами и хотите удалить его, вы можете просто отправить нам письмо по электронной почте по адресу [вставить адрес электронной почты здесь]. Убедитесь, что ваше сообщение содержит термины "DMCA", "авторское право", "удаление", так что мы можем легко экранировать его, так как мы получаем много е-mails.We будет немедленно прекратить и предотвратить дальнейшее нарушение авторских прав после уведомления. Если пользователь был найден нарушить политику авторских прав, то он / она столкнется с последствиями. {link} следует политику трех ударов. После того как мы получим соответствующее уведомление, что учетная запись пользователя определяется неподчинение политику защиты авторских прав, мы немедленно отключить весь доступ к материалу, включая доступ пользователя и отключить функцию совместного использования. Пользователь будет получать уведомления по электронной почте о наших действиях вместе с информацией, что нарушение его / ее был поставлен на запись для этой учетной записи под "три удара" правления злостным нарушителем политики прекращения. Функция обмена файлами будет возобновлена ​​только после того, как пользователь удостоверяет через электронный вариант подписи на {link} ссылка сайте, что он / она удалила все нарушения автrefundорских прав из его / ее счет. В случае, если пользователь нарушил политику защиты авторских прав в третий раз, учетная запись пользователя будет прекращено, а пользователь будет постоянно запрещен в {link} ссылку'],
                ['language' => 'en','translation' =>'To users, note that {link} only provides proxy service and not file-hosting. But we do our best to find and delete illegal contents, which are reported by our users. We take copyright violation very seriously and we are committed to protecting the rights of copyright owners. All premiumlinkgenerator.com users are bound by the Terms of Use and the law to respect owners’ rights. Users are not allowed to copy, adapt, distribute, or publicly display or perform works of the original work without the authorization of the respective copyright owner.In case you saw something illegal, i.e. persons under the age of 18 in a video or people doing illegal activities, please immediately report it to us by sending the links and file address or number. In the event that you find a content that you own with copyrights and want to remove it, you can simply send us an e-mail at [insert e-mail address here]. Make sure that your message contains the terms "dmca", "copyright", "removal", so we can easily screen it since we are receiving a lot of e-mails.We will immediately stop and further prevent copyright violation upon notice. If a user was found to violate Copyright policy, then he/she will face consequences. {link} follows a three strikes policy. Once we receive a valid notice that a user’s account is disobeying our Copyright Policy, we will immediately disable all access to the material including the user’s access and deactivate the sharing function. The user will be notified through e-mail regarding our actions together with the information that his/her violation has been put on the record for that account under the ‘three-strike’ rule of the Repeat Infringer Termination Policy. The file-sharing function will only be reactivated once the user certifies through an electronic signature option on {link} website that he/she removed all copyright infringing material from his/her account. In the case that the user has violated the Copyright Policy for the third time, the user’s account will be terminated and the user will be permanently banned in {link}'],
            ],
            [
                ['language' => 'ru','translation' =>'Политика возврата'],
                ['language' => 'en','translation' =>'Refund Policy'],
            ],
            [
                ['language' => 'ru','translation' =>'Здесь в премиум Link Generator, мы стремимся, чтобы убедиться, что наши члены удовлетворены нашей services.We уверены, что всем понравится наш сервис загрузки, потому что это просто и удобно. Более того, мы готовы поставить наш авторитет на линии, предлагая без риска возврата денег guarantee.In событие, которое вы не удовлетворены с вашей учетной записью Premium, вы можете попросить возврат в течение первых 2-х дней, и если вы не скачали более 8 Гб или более чем 10 различных файлов. Тем не менее, есть некоторые случаи, что клиент не имеет права на возврат денег из-за ограничений. В случае, если вы не знаете об этих ограничениях, пожалуйста, проверьте их здесь [приватность политика] .в ваш запрос, вам просто нужно указать причину, почему вы не удовлетворены нашим сервисом, и причина для желающих прекратить свое членство. Это очень важно для нас, и мы относимся к этому серьезно, потому что мы используем обратные связи клиентов постоянно развивать наши services.For ваши вопросы и запросы о возврате и отмены вашего членства, не стесняйтесь, чтобы отправить по электронной почте {support}'],
                ['language' => 'en','translation' =>'Here in Premium Link Generator, we aim to make sure that our members are satisfied with our services.We are confident that everyone will like our downloading service because it is simple and user-friendly. Moreover, we are willing to put our credibility on the line by offering a risk-free money-back guarantee.In the event that you are not satisfied with your Premium account, you can ask for a refund in the first 2 days and if you haven’t downloaded more than 8GB or more than 10 different files. However, there are some cases that a customer is not qualified for a refund due to restrictions. In case you are not aware of these limitations, please check them here [privacy-policy].In your request, you simply need to state the reason why you are not satisfied with our service and the reason for wanting to end your membership. This is very important to us and we take it seriously because we use customers’ feedbacks to continuously develop our services.For your questions and queries about the refund and cancellation of your membership, do not hesitate to send your e-mail to {support}'],
            ],

            //privacy policy page
            [
                ['language' => 'ru','translation' =>'Политика конфиденциальности'],
                ['language' => 'en','translation' =>'Privacy Policy'],
            ],
            [
                ['language' => 'ru','translation' =>'Premium Link Generator политика конфиденциальности'],
                ['language' => 'en','translation' =>'Premium Link Generator Privacy Policy'],
            ],
            [
                ['language' => 'ru','translation' =>'Здесь, в {link}, мы признаем и уважаем конфиденциальность наших пользователей через Интернет. Эта страница посвящена предоставлению информации о частной жизни и процессе сбора данных для сайта: {link}'],
                ['language' => 'en','translation' =>'Here in {link}, we recognize and respect the privacy of our users over the internet. This page is dedicated to providing information about the privacy and process of collecting data for the site: {link}'],
            ],
            [
                ['language' => 'ru','translation' =>'Целью нашего сайта является предоставление платформы, где пользователи могут скачивать файлы с нескольких веб-сайтов, хостинг с помощью учетной записи Премиум Link Generator. Премиум генератор Link работает, связывая пользователей с файлообменных сетей или онлайн-сервисов облачных. Администраторы или серверы генератора премиум Link не имеет никакого контроля над файлами, хранящимися удаленно или файлы, загруженные пользователями. Личная информация, которую вы добровольно предоставить наш веб-сайт используется, так что вы можете воспользоваться нашими услугами. Если вы не хотите, чтобы предоставить нам такую информацию, то вы не можете быть членом.'],
                ['language' => 'en','translation' =>'The purpose of our website is to provide a platform where users can download files from several hosting websites by using a Premium Link Generator account. Premium Link generator works by linking users with file-sharing networks or online cloud services. The administrators or servers of Premium Link generator has no control over the files stored remotely or the files uploaded by the users. The personal information that you willingly provide to our website is used so you can benefit from our services. If you don’t want to provide such information to us, then you can’t be a member.'],
            ],
            [
                ['language' => 'ru','translation' =>'Премиум-Link Generator Сайт и Сайты третьих сторон'],
                ['language' => 'en','translation' =>'The Premium Link Generator Site and Third Party Sites'],
            ],
            [
                ['language' => 'ru','translation' =>'Эта политика конфиденциальности относится только к премиум Link Generator сайта. Ссылки на сайты третьих лиц, которые Премиум Link Generator может содержать не принадлежат или контроль нами, и мы не берем на себя ответственность за ее содержание, политику конфиденциальности или практики. Пользователи соглашаются, что они несут ответственность за рассмотрение и понимание политики конфиденциальности (если таковые имеются) любых сайтов третьих лиц, которые пользователи могут получить доступ через этот сайт. При использовании этого сайта, вы не будете держать Премиум Link Generator от любой ответственности, которые могут возникнуть в связи с использованием любого стороннего сайта, к которому этот сайт может быть связано. <br> Основываясь на информации, которую мы собираем, мы используем его обеспечить и улучшить обслуживание, то с сайта, и связанные с ними функции, чтобы управлять подпиской пользователей и дать им возможность пользоваться и легко перемещаться по сайту. Ниже приведен список типов и категорий информации, которая собирает наш сайт.'],
                ['language' => 'en','translation' =>'This Privacy Policy only applies to Premium Link Generator Site. The links to third party sites that Premium Link Generator may contain are not owned or control by us and we assume no responsibility for its content, privacy policies, or practices. Users agree that they are responsible for reviewing and understanding the privacy policy (if any) of any third party sites that users may access through this Site. When you use this Site, you will not hold Premium Link Generator from any and all liability that may arise from using any third-party site to which this Site may be linked.<br>Based on the information that we collect, we use it to provide and improve the Service, the Site, and the related features, to administer users subscription and to enable them to enjoy and easily navigate the Site. Below is the list of types and categories of information that our Site collects.'],
            ],
            [
                ['language' => 'ru','translation' =>'Наш сайт собирает личную информацию с помощью:'],
                ['language' => 'en','translation' =>'Our Site collects the personal information using:'],
            ],
            [
                ['language' => 'ru','translation' =>'регистрация'],
                ['language' => 'en','translation' =>'Registration'],
            ],
            [
                ['language' => 'ru','translation' =>'Вам необходимо создать учетную запись на нашем сайте, чтобы стать пользователем. Вам необходимо предоставить контактную информацию, включая адрес электронной почты и пароль, который вы признаете и четко признать, как личную информацию, используемую для идентификации пользователя. Ваш пароль будет отправлен по электронной почте вы предоставили, который может быть изменен в любое время, войдя в свою учетную запись и редактирование раздела "Мои Данные".'],
                ['language' => 'en','translation' =>'You are required to create an account on our Site to become a user. You need to provide contact information including e-mail address and a password, which you recognize and clearly acknowledge as personal information used to identify you. Your account’s password will be sent through the e-mail you provided, which can be changed anytime by logging into your account and editing your ‘My Details’ section.'],
            ],
            [
                ['language' => 'ru','translation' =>'Лог Данные'],
                ['language' => 'en','translation' =>'Log Data'],
            ],
            [
                ['language' => 'ru','translation' =>'Просто просматривая наш сервер автоматически записывает информацию о вашем использовании Сайта. Log Data может содержать информацию, такую как IP-адрес, тип браузера, программное обеспечение вы используете, страницы сайта, которые вы посетили, время, проведенное на этих страницах, информация, которую вы искали на Сайте, время доступа и даты, и другие статистические данные. Информация, которую мы собираем, используется для мониторинга и анализа использования Сайта и предоставления услуг, для технической администрации сайта, для улучшения функциональности и доступности сайта, а также настроить его в зависимости от наших потребностей пользователей.'],
                ['language' => 'en','translation' =>'Simply browsing our server automatically records information about your use of the Site. The Log Data may contain information, such as your IP address, browser type, the software you were using, pages of the Site that you visited, the time spent on those pages, the information you searched on the Site, access times and dates, and other statistics. The information we collect is used to monitor and analyze the use of the Site and the Service, for the Site’s technical administration, to improve Site’s functionality and accessibility, and to customize it depending on our users’ needs.'],
            ],
            [
                ['language' => 'ru','translation' =>'Cookies'],
                ['language' => 'en','translation' =>'Cookies'],
            ],
            [
                ['language' => 'ru','translation' =>'Премиум Link Generator использует куки-файлы и файлы веб-журнала, как и другие веб-сайты, чтобы отслеживать использование сайта. Один тип печенья, которые мы используем известен как "упорного" куки, которая позволяет сайту распознавать вас как пользователя, когда вы вернетесь, используя один и тот же компьютер и веб-браузер. Таким образом, вам не нужно будет войти в систему, прежде чем пользоваться услугой. Если настройки браузера не позволяют печенье, то вы не сможете войти в свой аккаунт Премиум Link Generator Premium. Данные файла куки и журнала также используется, чтобы настроить свой опыт на нашем сайте, который похож на информацию, которую вы вводите при регистрации.'],
                ['language' => 'en','translation' =>'Premium Link Generator uses cookies and web log files like other websites in order to track site usage. One type of cookie that we are using is known as ‘persistent’ cookie, which allows the Site to recognize you as a user when you return using the same computer and web browser. Thus, you won’t need to log in before using the service. If your browser settings don’t allow cookies, then you won’t be able to login to your Premium Link Generator Premium account. The cookie and log file data is also used to customize your experience on our Site, which is similar to the information that you enter at the registration.'],
            ],
            [
                ['language' => 'ru','translation' =>'Файлы журналов, IP-адреса, а также информацию о вашем компьютере'],
                ['language' => 'en','translation' =>'Log files, IP addresses, and information about your computer'],
            ],
            [
                ['language' => 'ru','translation' =>'Когда пользователи посещают премиум Link Generator сайт, мы автоматически получаем информацию от них из-за стандартов связи в Интернете. , Что мы получаем информацию включает в себя URL-адрес сайта, с которого пришли пользователи и сайт, на который пользователи будут, когда они покидают сайт, IP-адрес своего компьютера или прокси-сервера, который они используют для доступа к Интернету, их компьютеры операционной системы и тип браузера они используют, шаблоны электронной почты, а также имя своего провайдера. Информация, которую мы получили поможет нам улучшить обслуживание сайта на основе анализа общих тенденций. Третьи лица, не получат никакого доступа к пользователям IP-адреса и личную информацию без их разрешения, если это не требуется по закону.'],
                ['language' => 'en','translation' =>'When users visit Premium Link Generator site, we automatically receive information from them due to the communications standards on the internet. The information that we receive includes the URL of the site from which users came and the site to which users are going when they leave the Site, IP address of their computer or the proxy server they use to access the internet, their computers operating system and the type of browser they are using, e-mail patterns, and the name of their ISP. The information we received will help us improve the Site’s service by analyzing overall trends. Third parties won’t get any access to users IP address and personally identifiable information without their permission unless it is required by the law.'],
            ],
            [
                ['language' => 'ru','translation' =>'связи Premium Link Generator'],
                ['language' => 'en','translation' =>'Premium Link Generator Communications'],
            ],
            [
                ['language' => 'ru','translation' =>'Связь между администраторами и пользователями сайта будет осуществляться через электронную почту, уведомления на форуме сайта, а также другие средства услуг, таких как текст и другие формы обмена сообщениями. Для того, чтобы изменить свою электронную почту и контактные предпочтения, просто войти в свою учетную запись и редактирование раздела "Мои Данные".'],
                ['language' => 'en','translation' =>'Communication between the Site administrators and users will be through e-mail, notices on the forum site, and other means of services like text and other forms of messaging. To change your e-mail and contact preferences, simply log in to your account and edit ‘My Details’ section.'],
            ],
            [
                ['language' => 'ru','translation' =>'Обмен информацией с третьими лицами'],
                ['language' => 'en','translation' =>'Sharing Information with Third Parties'],
            ],
            [
                ['language' => 'ru','translation' =>'Сайт придает важность конфиденциальности наших пользователей. Таким образом, мы не продаем, аренды или предоставить вашу личную информацию третьим лицам в маркетинговых целях. Мы будем делать только такую вещь на основе ваших инструкций или для предоставления конкретных услуг или информации. Например, мы используем кредитные компании обработки карт взимать плату с пользователей премиум аккаунты. Тем не менее, эти третьи лица не сохраняют, совместно использовать или хранить личную информацию, кроме как для оказания этих услуг. Они обязаны соглашений о конфиденциальности, которые ограничивают их использование такой информации.'],
                ['language' => 'en','translation' =>'The Site gives importance to the privacy of our users. Thus, we do not sell, rent, or provide your personally identifiable information to third parties for marketing purposes. We will only do such thing based on your instructions or to provide specific services or information. For example, we use credit card processing companies to charge users for premium accounts. However, these third parties do not retain, share, or store any personally identifiable information except to provide these services. They are obliged by confidentiality agreements that limit their use of such information.'],
            ],
            [
                ['language' => 'ru','translation' =>'Фишинг'],
                ['language' => 'en','translation' =>'Phishing'],
            ],
            [
                ['language' => 'ru','translation' =>'Фишинга и кражи личных данных являются основными проблемами на нашем сайте. Таким образом, защита информации наших пользователей является нашим главным приоритетом. Мы не знаем и не будет, в любое время, попросите вашу личную информацию, включая информацию о кредитных картах, вашей учетной записи ID, логин пароль, используя незащищенный или незапрошенный по электронной почте или по телефону.'],
                ['language' => 'en','translation' =>'Phishing and identity theft are major concerns on our Site. Thus, protecting our users’ information is our top priority. We do not and will not, at any time, ask for your personal information including credit card information, your account ID, login password using a non-secure or unsolicited e-mail or via phone call.'],
            ],
            [
                ['language' => 'ru','translation' =>'Ссылки на другие сайты'],
                ['language' => 'en','translation' =>'Links to Other Sites'],
            ],
            [
                ['language' => 'ru','translation' =>'Вы найдете ссылки третьих лиц на нашем сайте, но мы не поддерживаем, разрешать или представлять какую-либо связь этих сайтов третьих лиц, ни одобрить их частную жизнь или политику информационной безопасности или практики. Мы не контролируем эти веб-сайты третьих лиц. Таким образом, мы рекомендуем нашим пользователям ознакомиться с политикой конфиденциальности или заявления других веб-сайтов, которые вы посещаете. Эти сайты третьих сторон могут размещать свои куки или других файлов на вашем компьютере, собирать данные или попросить у вас личную информацию. Они следуют различные правила, касающиеся использования или раскрытия личной информации, которую вы им подчиняться.'],
                ['language' => 'en','translation' =>'You will find third party links in our site but we do not endorse, authorize, or represent any affiliation to these third party websites nor endorse their privacy or information security policies, or practices. We do not control these third party websites. Thus, we encourage our users to read the privacy policies or statements of the other websites you visit. These third party sites may place their own cookies or other files on your computer, collect data or ask personal information from you. They follow different rules regarding the use or disclosure of the personal information you submit to them.'],
            ],
            [
                ['language' => 'ru','translation' =>'Доступ и изменение информации об учетной записи'],
                ['language' => 'en','translation' =>'Accessing and Changing your Account Information'],
            ],
            [
                ['language' => 'ru','translation' =>'Информация, которую пользователи предоставленные на нашем сайте могут быть пересмотрены и изменены в любое время, просто войдя в учетной записи пользователя на сайте Премиум Link Generator. Тем не менее, даже после того, как требуемая для изменения пользователем обрабатывается, сайт может в течение времени удержания остаточной информации в ее резервной копии и / или архивных копий базы данных.'],
                ['language' => 'en','translation' =>'The information that users provided on our Site can be reviewed and changed anytime by simply logging into the user’s account on the Premium Link Generator site. However, even after the user requested for a change is processed, the Site may for a time retain residual information in its backup and/or archival copies of its database.'],
            ],
            [
                ['language' => 'ru','translation' =>'Удаление аккаунта'],
                ['language' => 'en','translation' =>'Deleting your Account'],
            ],
            [
                ['language' => 'ru','translation' =>'Пользователи могут легко запросить, чтобы удалить свой аккаунт в любое время. Обратите внимание, что Премиум Link Generator сайт может сохранить определенные данные, предоставленные пользователем, которые, по нашему мнению могут быть использованы для предотвращения мошенничества или будущего злоупотребления, законных деловых целей, таких как анализ агрегированных, неличные данные, а также восстановление аккаунта, или, если это требуется закон. Чтобы удалить учетную запись, пожалуйста, отправьте нам запрос на {} поддержки и он будет удален как можно скорее. "'],
                ['language' => 'en','translation' =>'Users can easily request to delete their account at any time. Note that Premium Link Generator site may retain certain data contributed by the user, which we believe can be used to prevent fraud or future abuse, legitimate business purposes like analysis of aggregated, non-personally identifiable data, and account recovery, or if required by the law. To delete your account, please send us a request at {support} and it will be deleted as soon as possible.'],
            ],
            [
                ['language' => 'ru','translation' =>'Ваши обязательства'],
                ['language' => 'en','translation' =>'Your Obligations'],
            ],
            [
                ['language' => 'ru','translation' =>'Пользователи также имеют определенные обязательства, налагаемые действующим законодательством и нормативными актами: Пользователи все время должны соблюдать Правила и условия на текущей Политики конфиденциальности и условия использования, включая все права на интеллектуальную собственность, которые могут принадлежать третьим parties.Users должен не загружать или распространять любую информацию, которую можно рассматривать как вредный, пропагандирующими насилие, оскорбительными, расистскими или xenophobic.We принять эти принципы очень серьезно и считаем это основа, на которой наши пользователи следуют к премиум Link Generator сайта и услуг мы предлагаем. Таким образом, любое нарушение этих правил может привести к ограничению, приостановлению или прекращению учетной записи пользователя.'],
                ['language' => 'en','translation' =>'Users also have certain obligations that are imposed by applicable law and regulations:Users must all the time respect the Terms and Conditions of the then-current Privacy Policy and the Terms of Use including all intellectual property rights which may belong to third parties.Users must not download or distribute any information which can be considered to be injurious, violent, offensive, racist, or xenophobic.We take these principles very seriously and consider these to be the basis on which our users follow to the Premium Link Generator Site and the services we offer. Thus, any violation of these guidelines may lead to the restriction, suspension, or termination of user’s account.'],
            ],
            [
                ['language' => 'ru','translation' =>'Изменения в политике'],
                ['language' => 'en','translation' =>'Changes to This Policy'],
            ],
            [
                ['language' => 'ru','translation' =>'Время от времени, мы можем пересмотреть нашу политику конфиденциальности. Таким образом, мы рекомендуем нашим пользователям периодически посещать эту страницу, чтобы быть в курсе любых таких изменений. Тем не менее, мы не будем использовать имеющуюся информацию наших пользователей в способе ранее не были раскрыты. Пользователи будут оповещены и дали выбор, чтобы отказаться от любого нового использования их информации.'],
                ['language' => 'en','translation' =>'From time to time, we may revise our privacy policy. Thus, we encourage our users to periodically visit this page to be aware of any such revisions. However, we will not use our users’ existing information in a method not previously disclosed. Users will be advised and given the choice to opt out of any new use of their information.'],
            ],
            [
                ['language' => 'ru','translation' =>'Как связаться с нами'],
                ['language' => 'en','translation' =>'How to Contact Us'],
            ],
            [
                ['language' => 'ru','translation' =>'Для получения каких-либо запросов или опасения относительно этой страницы, не стесняйтесь связаться с нашим координатором сайта по адресу {support}'],
                ['language' => 'en','translation' =>'For any queries or concerns regarding this page, do not hesitate to contact our site coordinator at {support}'],
            ],
        ];

        for ($i = 0; $i < count($source); $i++) {
            $data = $this->insert('{{%source_message}}',$source[$i]);
            $id = Yii::$app->db->getLastInsertID();
            foreach ($source_translations[$i] as $key) {
                Yii::$app->db->createCommand('INSERT INTO `message` (`id`,`language`,`translation`) VALUES (:id,:language,:translation)', [
                    ':id' => $id,
                    ':language' => $key['language'],
                    ':translation'=>$key['translation'],
                ])->execute();                            
            }            
        }
    }

    public function down()
    {
        echo "m161108_155819_sedd_testing_translations_for_all_pages cannot be reverted.\n";

        return false;
    }

}
