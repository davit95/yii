<?php

use yii\db\Migration;

class m161110_090204_seed_terms_translation_data extends Migration
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
            //terms
            ['category' => 'terms', 'message' => 'Terms of use'],
            ['category' => 'terms', 'message' => 'Supported Hosters Non-Responsibility'],
            ['category' => 'terms', 'message' => 'Thank you for visiting the Premium Link Generator website located at {link}. When you access or use the Site and register as a premium member of the Site (Premium Access), it means that you fully agree to follow the Premium Link Generator website Terms and Conditions (Terms and Conditions).<br>The Terms and Conditions are part of Premium Link Generator Policy (Privacy Policy) and any and all other applicable operating rules, policies, price, schedules, and other supplemental terms and conditions, or documents that may be changed every now and then, which are specifically integrated herein by reference (collectively, the Agreement).Please carefully review the Agreement. In case that you don’t agree to the whole terms and conditions included in the Agreement then you are not allowed to use the Site or Service at all.'],
            ['category' => 'terms', 'message' => 'Scope of Agreement'],
            ['category' => 'terms', 'message' => 'You agree to the terms and conditions stated in the Agreement so that you can use the Site and Services. The Agreement represents the complete and only agreement between you and Premium Link Generator regarding your use of the Site and Services. It replaces all previous or current agreements, warranties, and/or understanding regarding your use of the Services, Site, and the content included therein and/or any other products and services provided by or through same.'],
            ['category' => 'terms', 'message' => 'Modification of Agreement'],
            ['category' => 'terms', 'message' => 'We may modify the Agreement every now and then depending on our preference, without specific notice to our users. The most recent Agreement is posted on the Site so users should review the Agreement before using the Site. If you choose to continuously use the Site and/or Service, you hereby agree to obey with and be obliged by, all the terms and conditions included within the Agreement effective at that time. Thus, we encourage our users to regularly check this page for updates or changes. Any future offer/s or product/s made available on the Site that enhances the current features of the Site will be subjected to the Agreement except clearly stated otherwise. You understand and agree that Premium Link Generator is not responsible or liable in any way if you can’t use the Site, become a Member, or use the Services.'],
            ['category' => 'terms','message'=>'Registration'],
            ['category' => 'terms', 'message' => 'In order to use Premium Services, you must first register to Premium Link Generator. You must provide information like your e-mail address and other information requested by the Site on the Registration. You agree to provide true, accurate, current, and complete Registration Data in order to maintain it updated and accurate. The Site will verify and approve all Registrations based on its standard verification procedures. Premium Link Generator has the right to deny the Registration of anyone at any time and for any reason. Using your username and password, which you can change based on your preference, you can access your Premium Link Generator account. You are responsible for maintaining the privacy of your account information and restricting access to your computer. You agree to accept responsibility for all the activities that will be done using your Premium Link Generator account including any and all purchases made.'],
            ['category' => 'terms', 'message' => 'Fair Use Policy'],
            ['category' => 'terms', 'message' => 'It is important that all users enjoy the same quality of service from Premium Link Generator. Users should not abuse the system including, but not limited to, using content which utilizes too much CPU time or storage space, using excessive bandwidth, or reselling access to the content hosted on Premium Link Generator servers. The Site reserves the right to control and restrict accounts that are suspected to be abusing the Service using an advanced system.'],
            ['category' => 'terms','message'=>"Daily Fair Use & Limitations"],
            ['category' => 'terms', 'message' => 'Premium Link Generator has the right to put a limit on downloads of users, which can be daily, weekly, or monthly basis or any other limitations that can be considered necessary by the Site. The limitation can be set by Premium Link Generator to specific filehosters, specific users, or groups of users who are suspected that are not using the Services in a fair way.'],
            ['category' => 'terms', 'message' => 'Premium Link Generator is NOT responsible when a file-hoster chooses to terminate any contract with the Site. However, the Site gives their best so this won’t happen.'],
            ['category' => 'terms', 'message' => 'Account Restrictions'],
            ['category' => 'terms', 'message' => 'Sharing of account with other users.'],
            ['category' => 'terms', 'message' => 'Below is the list of things not allowed in Premium Link Generator. If you violated any of the restrictions, the Site has the right to restrict, terminate your account, or change your password.'],
            ['category' => 'terms', 'message' => 'Users can’t publish their account details (username & password) on forums, blogs, or anywhere on the internet'],
            ['category' => 'terms', 'message' => 'Downloading files simultaneously from different IP addresses.'],
            ['category' => 'terms', 'message' => 'Resell the Premium Link Generator Services without any agreement with the Site.'],
            ['category' => 'terms', 'message' => 'Use the Premium Link Generator site to provide similar services.'],
            ['category' => 'terms', 'message' => 'Resell Oron links from Premium Link Generator.'],
            ['category' => 'terms', 'message' => 'Rejection/Termination'],
            ['category' => 'terms', 'message' => 'Premium Link Generator can decide to reject your Registration and/or terminate your Membership anytime and for any reason, which include but not limited to: breaching the Agreement, conducting unauthorized commercial activity using your Membership and for other reasons stated in Point 5.'],
            ['category' => 'terms', 'message' => 'Cancellation of Membership'],
            ['category' => 'terms', 'message' => 'If you are not completely satisfied with our Services, you may cancel your Membership anytime. You can either simply cease using the site or send us an e-mail to [insert e-mail address here] with your request. Cancellation of your membership is your sole right and remedy regarding any dispute with Premium Link Generator.'],
            ['category' => 'terms', 'message' => 'Description of Services'],
            ['category' => 'terms', 'message' => 'Premium Link Generator works like a proxy server so users can download and store legitimate files hosted in third-party cloud services in high-speed and without the need to subscribe. The Site is doing everything to prevent the distribution of copyrighted files by using all available technology and methods, such as:'],
            ['category' => 'terms', 'message' => 'Name filters. If the file name is subject to intellectual property right then downloading the file is allowed.'],
            ['category' => 'terms', 'message' => 'DMCA File List. Users can’t store files that were included in the list of Premium Link Generator which violate the DMCA. Note: The Site has a relevant form that members and non-members can use to report these kinds of files.'],
            ['category' => 'terms', 'message' => 'When Premium Link Generator receives a DMCA complaint or detects that a file is subject to copyright, the Site immediately notifies the cloud service where it is stored. The file will be immediately deleted from the website where it is stored so the distribution and sharing of the file will be impossible.'],
            ['category' => 'terms', 'message' => 'There are also other methods that Premium Link Generator uses to prevent the distribution of copyrighted files. However, these can’t be disclosed publicly so hostile users can’t evade them.Premium Link Generator only operates like a proxy server with private members that can download files. The Site DOES NOT pay anyone to upload or download files. The servers only act as a proxy and DO NOT store any file.'],
            ['category' => 'terms', 'message' => 'Member Content'],
            ['category' => 'terms', 'message' => 'The downloaded files through the Site by members are their responsibility and for any and all succeeding uses of the Generated URLs. Before you post Download Generated URLs, you must be sure that you have all the essential ownership and other rights for these. Users must agree to use the Services in accordance with any and all applicable laws and regulations.<br>Below is the list of things that you shouldn’t do regarding the Generated URLs:'],
            ['category' => 'terms', 'message' => 'Any content that can be considered to be unlawful, harmful, threatening, defamatory, obscene, harassing, or otherwise objectionable shouldn’t be downloaded;'],
            ['category' => 'terms', 'message' => 'An account will be immediately terminated if the user downloads any content that violates any trademark, trade name, service mark, copyright license, or other intellectual property, or proprietary right of any third party;'],
            ['category' => 'terms', 'message' => 'Personally identifiable information of any third-person shouldn’t be downloaded including telephone numbers, street addresses, last names, URLs, and e-mail addresses;'],
            ['category' => 'terms', 'message' => 'Without prior authorization, users shouldn’t download any audio files, text, photographs, videos, and other images containing confidential information;'],
            ['category' => 'terms', 'message' => 'Obscene files, which are defined under applicable law, including audio files, text, photographs, or other images shouldn’t be downloaded;'],
            ['category' => 'terms', 'message' => 'Users should never express or imply that any of their statements were endorsed by Premium Link Generator without or specific written consent;'],
            ['category' => 'terms', 'message' => 'Without consent, users can’t collect personal information about end-users or other third parties;'],
            ['category' => 'terms', 'message' => 'Users should never retrieve, index, or in any way reproduce or by-pass the navigational structure of the Site, Services, or related content using any robot, spider, site search/retrieval application, or other manual or automatic device;'],
            ['category' => 'terms', 'message' => 'The Services, the Site, and/or the server and/or networks connected should never be interrupted or destroy by the users;'],
            ['category' => 'terms', 'message' => 'Software that contains viruses or other computer code, files, or programs designed to disrupt, damage, or limit the functionality of any computer software or hardware or telecommunications equipment shouldn’t be posted, offer for download, e-mail or otherwise transmit any material;'],
            ['category' => 'terms', 'message' => 'Spyware, adware, and other programs designed to send unsolicited advertisements services shouldn’t be posted, offer for download, transmit, promote, or make available any software, products, or services that are illegal or that violates the rights of a third-party. This software is designed to initiate ‘denial of service’ attacks, mail bomb programs, and other programs designed to infiltrate access to networks on the internet;'],
            ['category' => 'terms', 'message' => 'Any part of the Site and/or Services shouldn’t be ‘frame’ or ‘mirror’ without Premium Link Generator’s written consent;'],

            ['category' => 'terms', 'message' => 'Immediate account termination and spreading of member details to the authorities will be done in case someone uses our services for content that can be considered abusive to children or illegal pornography;'],
            ['category' => 'terms', 'message' => 'Any part of the Site and/or Service shouldn’t be modified, adapted, sublicensed, translated, sell, reverse engineer, decipher, decompile, or otherwise disassemble;'],
            ['category' => 'terms', 'message' => 'Generated URLs can only be used by the owner of Premium Link Generator account. It’s not allowed to post or share these with anyone and only works with the account that generated them.If a user was found violating any of these practices, it will be deemed as a breach of the Agreement and the account will be immediately terminated without notice. Premium Link Generator has the right to do any legal action against members that will violate the Member Content section.'],
            ['category' => 'terms', 'message' => 'Non-Endorsement/Neutral Party'],
            ['category' => 'terms', 'message' => 'Premium Link Generator works the Site and Services as a neutral party. Thus, the Site doesn’t regularly monitor, regulate, or watch the use of the Site and/or Services by any of its Members. However, it doesn’t mean that Premium Link Generator endorse any activity of the Members. The Site is not responsible for the Member or other third-party’s acts, omissions, agreements, promises, content links, other products, services, comments, opinions, advice, statements, offers, and/or other information made available.'],
            ['category' => 'terms', 'message' => 'Proprietary Rights'],
            ['category' => 'terms', 'message' => 'The Premium Link Generator is protected under applicable copyrights, trademarks, and other proprietary rights, such as its content, organization, graphics, design, compilation, magnetic translation, digital conversion, software, services, and other matters. Thus, it is strictly prohibited to copy, redistribute, or publish any part of Premium Link Generator. Users do not acquire ownership rights to any part of Premium Link Generator viewed at or through the Site.'],
            ['category'=>'terms','message'=>'Legal Warning'],
            ['category' => 'terms', 'message' => 'Attempt to damage, destroy, tamper with, vandalize, and/or interfere with the operation of the Site and/or Services is a violation of criminal and civil law. Premium Link Generator will pursue legal actions against individual or entity to the fullest extent approved by the law and in equity.'],
            ['category' => 'terms', 'message' => 'Premium Membership Fees'],
            ['category' => 'terms', 'message' => 'When you register for our Premium Services and use any method of payment, your account will be charged the applicable amount based on what you choose. All charges are billed in U.S. Dollars. If members don’t want to use Premium Services, it doesn’t mean that they refuse to pay any of the fees.'],
            ['category' => 'terms', 'message' => 'Third Party Websites'],
            ['category' => 'terms', 'message' => 'Premium Link Generator contains a link to other websites on the internet, which are owned and operated by third parties. Note that the inclusion of all these links doesn’t imply that the Site endorses these third-party websites or has any association with the website operators. The Site has no control over the information, products, or services on these third-party websites. Thus, users agree that Premium Link Generator can’t be held liable or responsible for the availability or the operation of these third-party sites. Any kind of transaction, dealings, participations offered on the advertiser’s site including payment and delivery of related products or service, or any other terms, conditions, warranties, or representations associated with the transactions are solely between you and the applicable third-party website. Premium Link Generator shall not be responsible, directly or indirectly, for any loss or damages caused by the products or services purchased by the user from any third-party website.'],
            ['category' => 'terms', 'message' => 'Disclaimer of Warranties'],
            ['category' => 'terms', 'message' => 'BASED FROM THE FULLEST EXTENT PERMITTED BY APPLICABLE LAW (INCLUDING, BUT NOT LIMITED TO, DISCLAIMER OF WARRANTIES OF MERCHANTABILITY, NON-INFRINGEMENT OF INTELLECTUAL PROPERTY, AND/OR FITNESS FOR A PARTICULAR PURPOSE), THE SITE, SERVICES, GENERATED URLS, AND/OR ANY PRODUCTS AND/OR SERVICES OFFERED ON THE SITE ARE PROVIDED TO USERS ON AN ‘AS IS’ AND ‘AS AVAILABLE’. PREMIUM LINK GENERATOR CAN’T GUARANTEE THAT THE SITE, SERVICES, GENERATED URLS, AND/OR ANY OTHER PRODUCTS AND/OR SERVICES OFFERED ON THE SITE WILL:'],
            ['category' => 'terms', 'message' => 'MEET USER’S REQUIREMENTS;'],
            ['category' => 'terms', 'message' => 'BE UNINTERRUPTED, TIMELY, SECURE, OR ERROR-FREE OR THAT DEFECTS WILL BE CORRECTED;'],
            ['category' => 'terms', 'message' => 'FREE OF VIRUSES OR OTHER HARMFUL CONTENTS;'],
            ['category' => 'terms', 'message' => 'SECURITY METHODS THAT WILL BE ENOUGH TO PROVIDE ENJOYMENT WITH THE USE OF THE SITE OR FIGHT AGAINST INFRINGEMENT; AND/OR'],
            ['category' => 'terms', 'message' => 'ACCURATE OR RELIABLE.'],
            ['category' => 'terms', 'message' => 'ANY CONTENT RELATED ON THE SITE MAY CONTAIN BUGS, ERRORS, PROBLEMS, OR OTHER LIMITATIONS. MOREOVER, THE SITE IS NOT RESPONSIBLE FOR THE AVAILABILITY OF THE UNDERLYING INTERNET CONNECTION RELATED TO THE SITE, SERVICES, AND/OR GENERATED URLS. ANYTHING THAT USERS OBTAINED FROM THE SITE SHALL NOT CREATE WARRANTY UNLESS IT WAS STATED IN THE AGREEMENT.'],
            ['category' => 'terms', 'message' => 'Limitations of Liability'],
            ['category' => 'terms', 'message' => 'PREMIUM LINK GENERATOR SHALL NOT BE LIABLE DIRECTLY, INDIRECTLY, INCIDENTALLY, SPECIALLY, CONSEQUENTIALLY, AND/OR EXEMPLARY TO THE USERS OR ANY THIRD-PARTY FOR ANY DAMAGES, LOSS OF PROFITS, GOODWILL, USE, DATA, OR OTHER INTANGIBLE LOSSES (EVEN IF PREMIUM LINK GENERATOR HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES) TO THE FULLEST EXTENT PERMITTED BY THE LAW FOR:'],
            ['category'=>'terms','message'=>'THE USE OR THE INABILITY TO USE THE SITE, SERVICES, GENERATED URLS AND/OR ANY OTHER PRODUCTS AND/OR SERVICES OFFERED ON THE SITE;'],
            ['category' => 'terms', 'message' => 'THE COST OF OBTAINING SUBSTITUTE GOODS AND SERVICES RESULTING FROM ANY GOODS, DATA, INFORMATION, CONTENT AND/OR ANY OTHER PRODUCTS PURCHASED OR OBTAINED FROM OR THROUGH THE SITE;'],
            ['category' => 'terms', 'message' => 'THE UNAUTHORIZED ACCESS TO, OR ALTERATION OF, YOUR REGISTRATION DATA; AND'],
            ['category' => 'terms', 'message' => 'ANY OTHER ISSUE INVOLVING TO THE SITE, SERVICES, GENERATED URLS AND/OR ANY OTHER PRODUCTS AND/OR SERVICES OFFERED ON THE SITE.'],
            ['category' => 'terms', 'message' => 'ALL OF THE LIMITATION STATED APPLIES, BUT NOT LIMITED TO, THE BREACH OF CONTRACT, BREACH OF WARRANTY, NEGLIGENCE, STRICT LIABILITY, MISREPRESENTATION, AND ANY AND ALL OTHER OFFENSES. PREMIUM LINK GENERATOR WILL BE RELEASED FROM ANY AND ALL OBLIGATIONS, LIABILITIES, AND CLAIMS IN EXCESS OF THE LIMITATIONS STATED. AFTER ONE (1) YEAR FOLLOWING THE EVENT, YOU OR THE SITE CAN’T DO ANY ACTION REGARDING THE ISSUE THAT AROSE OUT OF YOUR USE OF THE SITE, SERVICES, GENERATED URLS AND/OR ANY OTHER PRODUCTS AND/OR SERVICES OFFERED ON THE SITE. WITHOUT THESE LIMITATIONS, THE ACCESS OF THE SITE, SERVICES, GENERATED URLS, AND/OR ANY OTHER PRODUCTS AND/OR SERVICES OFFERED ON THE SITE WILL NOT BE PROVIDED TO USERS. NOTE: SOME JURISDICTIONS DO NOT ALLOW CERTAIN LIMITATIONS ON LIABILITY. THUS, PREMIUM LINK GENERATOR LIABILITY SHALL BE LIMITED TO THE MAXIMUM EXTENT PERMITTED BY THE LAW.'],
            ['category'=>'terms','message'=>'Editing, Deleting, and Modification'],
            ['category' => 'terms', 'message' => 'Any content, documents, information, or other materials that can be seen on the Site, can be edited and/or deleted with Premium Link Generator’s right and sole discretion.'],
            ['category' => 'terms', 'message' => 'User Information'],
            ['category' => 'terms', 'message' => 'Any of the materials that users submit or associated with the Site including, but not limited to, the Registration Data, shall be subjected to the Privacy Policy. You can read the Privacy Policy using the link below or click here {privacy_link}.'],
            ['category' => 'terms', 'message' => 'How to Contact Us'],
            ['category' => 'terms', 'message' => 'If you have any queries or concerns regarding the Agreement or the methods of Premium Link Generator do not hesitate to contact us here {link} Contact US'],
        ];    

            $source_translations = [
                //terms
                [
                    ['language' => 'ru', 'translation' => 'Условия для использования'],
                    ['language' => 'en', 'translation' => 'Terms of use'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Поддерживаемые Хостеров неответственности'],
                    ['language' => 'en', 'translation' => 'Supported Hosters Non-Responsibility'],
                ],  
                [
                    ['language' => 'ru', 'translation' => 'Благодарим Вас за посещение веб-сайта Премиум Link Generator, расположенный по адресу {link}. При доступе или использовать Сайт и зарегистрироваться в качестве премии члена сайта (Premium Access), это означает, что вы полностью согласны с тем, чтобы следовать Условия использования сайта Премиум Link Generator и условия (сроки и условия). <br> Правила и условия являются частью премиум Link Generator политики (Политика конфиденциальности) и любых и всех других применимых правил эксплуатации, политики, цены, расписания и других дополнительных условий или документов, которые могут быть изменены каждый сейчас и потом, которые специально интегрированы здесь в качестве ссылка (коллективно, соглашение) .Please внимательно изучить договор. В случае, если вы не согласны с целыми условия включены в соглашения, то вы не можете использовать Сайт или услугу.'],
                    ['language' => 'en', 'translation' => 'Thank you for visiting the Premium Link Generator website located at {link}. When you access or use the Site and register as a premium member of the Site (Premium Access), it means that you fully agree to follow the Premium Link Generator website Terms and Conditions (Terms and Conditions).<br>The Terms and Conditions are part of Premium Link Generator Policy (Privacy Policy) and any and all other applicable operating rules, policies, price, schedules, and other supplemental terms and conditions, or documents that may be changed every now and then, which are specifically integrated herein by reference (collectively, the Agreement).Please carefully review the Agreement. In case that you don’t agree to the whole terms and conditions included in the Agreement then you are not allowed to use the Site or Service at all.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Предмет соглашения'],
                    ['language' => 'en', 'translation' => 'Scope of Agreement'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Вы согласны с условиями и условиями, изложенными в Договоре, так что вы можете использовать сайт и услуги. Соглашение представляет собой полное и единственное соглашение между вами и премиум Link Generator относительно Вашего использования Сайта и Услуг. Он заменяет все предыдущие или текущие соглашения, гарантии, и / или понимание относительно использования Вами услуг, сайта, а содержание в них включены и / или любые другие продукты и услуги, предоставляемые через или же.'],
                    ['language' => 'en', 'translation' => 'You agree to the terms and conditions stated in the Agreement so that you can use the Site and Services. The Agreement represents the complete and only agreement between you and Premium Link Generator regarding your use of the Site and Services. It replaces all previous or current agreements, warranties, and/or understanding regarding your use of the Services, Site, and the content included therein and/or any other products and services provided by or through same.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Изменение Соглашения'],
                    ['language' => 'en', 'translation' => 'Modification of Agreement'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Мы можем изменить Соглашение каждый сейчас, а затем в зависимости от наших предпочтений, без специального уведомления для наших пользователей. Самое последнее Соглашение опубликовано на Сайте, поэтому пользователи должны пересмотреть соглашение перед использованием сайта. Если вы постоянно использовать Сайт и / или услуги, Вы тем самым соглашаетесь подчиняться и с понуждались, все условия и положения в рамках Соглашения, действующему на тот момент. Таким образом, мы рекомендуем нашим пользователям регулярно проверять эту страницу на наличие обновлений или изменений. Любое будущее предложение / с или продукт / с доступны на Сайте, что увеличивает текущие функции сайта будут подвергнуты соглашения, за исключением четко указано иное. Вы понимаете и соглашаетесь с тем, что Премиум Link Generator не несет ответственность в любом случае, если вы не можете использовать сайт, стать членом или использовать услуги.'],
                    ['language' => 'en', 'translation' => 'We may modify the Agreement every now and then depending on our preference, without specific notice to our users. The most recent Agreement is posted on the Site so users should review the Agreement before using the Site. If you choose to continuously use the Site and/or Service, you hereby agree to obey with and be obliged by, all the terms and conditions included within the Agreement effective at that time. Thus, we encourage our users to regularly check this page for updates or changes. Any future offer/s or product/s made available on the Site that enhances the current features of the Site will be subjected to the Agreement except clearly stated otherwise. You understand and agree that Premium Link Generator is not responsible or liable in any way if you can’t use the Site, become a Member, or use the Services.'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Регистрация'],
                    ['language' => 'en', 'translation' => 'Registration'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Для того, чтобы использовать Премиум Услуги, Вы должны сначала зарегистрироваться на премиум Link Generator. Вы должны предоставить информацию, как ваш адрес электронной почты и прочая информация, запрошенной Сайта о регистрации. Вы согласны с тем, чтобы предоставить достоверную, точную, актуальную и полные данные о регистрации в целях сохранения ее обновленной и точной. Сайт будет проверять и утверждать все регистрациями на основе своих стандартных процедур проверки. Премиум Ссылка Генератор имеет право отказать в регистрации любому в любое время и по любой причине. Используя свое имя пользователя и пароль, которые вы можете меняться в зависимости от ваших предпочтений, вы можете получить доступ к учетной записи премиум Link Generator. Вы несете ответственность за сохранение конфиденциальности информации вашей учетной записи и ограничения доступа к компьютеру. Вы согласны с тем, чтобы принять на себя ответственность за все виды деятельности, которые будут сделаны, используя учетную запись Премиум Link Generator, включая любые и все покупки, сделанные.'],
                    ['language' => 'en', 'translation' => 'In order to use Premium Services, you must first register to Premium Link Generator. You must provide information like your e-mail address and other information requested by the Site on the Registration. You agree to provide true, accurate, current, and complete Registration Data in order to maintain it updated and accurate. The Site will verify and approve all Registrations based on its standard verification procedures. Premium Link Generator has the right to deny the Registration of anyone at any time and for any reason. Using your username and password, which you can change based on your preference, you can access your Premium Link Generator account. You are responsible for maintaining the privacy of your account information and restricting access to your computer. You agree to accept responsibility for all the activities that will be done using your Premium Link Generator account including any and all purchases made.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Добросовестное использование политики'],
                    ['language' => 'en', 'translation' => 'Fair Use Policy'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Важно, чтобы все пользователи пользуются теми же качество обслуживания от премиум Link Generator. Пользователи не должны злоупотреблять системой, включая, но не ограничиваясь этим, использование контента, который использует слишком много процессорного времени или места для хранения, используя чрезмерную пропускную способность, или перепродавать доступ к контенту, размещенных на серверах премиум Link Generator. Сайт оставляет за собой право контролировать и ограничивать счета, которые подозреваются в злоупотреблении службе с помощью передовой системы.'],
                    ['language' => 'en', 'translation' => 'It is important that all users enjoy the same quality of service from Premium Link Generator. Users should not abuse the system including, but not limited to, using content which utilizes too much CPU time or storage space, using excessive bandwidth, or reselling access to the content hosted on Premium Link Generator servers. The Site reserves the right to control and restrict accounts that are suspected to be abusing the Service using an advanced system.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Ежедневно добросовестное использование и ограничения'],
                    ['language' => 'en', 'translation' => 'Daily Fair Use & Limitations'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Премиум Ссылка Генератор имеет право поставить ограничение на загрузки пользователей, которые могут быть ежедневно, еженедельно или ежемесячно или каких-либо других ограничений, которые могут быть сочтены необходимыми Сайтом. Ограничение может быть установлено премиум Link Generator для конкретных filehosters, определенных пользователей или групп пользователей, которые подозреваются в том, что не пользуясь услугами справедливым образом.'],
                    ['language' => 'en', 'translation' => 'Premium Link Generator has the right to put a limit on downloads of users, which can be daily, weekly, or monthly basis or any other limitations that can be considered necessary by the Site. The limitation can be set by Premium Link Generator to specific filehosters, specific users, or groups of users who are suspected that are not using the Services in a fair way.'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Премиум Link Generator не несет ответственности, если файл-хостер выбирает прекращение любого контракта с сайтом. Тем не менее, сайт дает их лучше всего так что это не произойдет.'],
                    ['language' => 'en', 'translation' => 'Premium Link Generator is NOT responsible when a file-hoster chooses to terminate any contract with the Site. However, the Site gives their best so this won’t happen.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Ограничения учетной записи'],
                    ['language' => 'en', 'translation' => 'Account Restrictions'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Совместное использование учетной записи с другими пользователями.'],
                    ['language' => 'en', 'translation' => 'Sharing of account with other users.'],
                ],  
                [
                    ['language' => 'ru', 'translation' => 'Ниже приведен список вещей, которые не допускаются в премиум Link Generator. При нарушении любого из ограничений, сайт имеет право ограничить, прекратить действие Вашей учетной записи, или изменить свой пароль.'],
                    ['language' => 'en', 'translation' => 'Below is the list of things not allowed in Premium Link Generator. If you violated any of the restrictions, the Site has the right to restrict, terminate your account, or change your password.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Пользователи не могут публиковать свои реквизиты (имя пользователя и пароль) на форумах, блогах, или где-нибудь в Интернете'],
                    ['language' => 'en', 'translation' => 'Users can’t publish their account details (username & password) on forums, blogs, or anywhere on the internet'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Загрузка файлов одновременно с разных IP-адресов.'],
                    ['language' => 'en', 'translation' => 'Downloading files simultaneously from different IP addresses.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Перепродать Премиум Link Generator услуги без согласования с сайтом.'],
                    ['language' => 'en', 'translation' => 'Resell the Premium Link Generator Services without any agreement with the Site.'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'С помощью сайта Премиум Link Generator предоставлять аналогичные услуги.'],
                    ['language' => 'en', 'translation' => 'Use the Premium Link Generator site to provide similar services.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Перепродажа Орон ссылки от премиум Link Generator.'],
                    ['language' => 'en', 'translation' => 'Resell Oron links from Premium Link Generator.'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Отторжение / прекращение действия'],
                    ['language' => 'en', 'translation' => 'Rejection/Termination'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Премиум Link Generator может принять решение об отказе Вашей регистрации и / или прекратить ваше членство в любое время и по любой причине, которые включают в себя, но не ограничиваясь: нарушение Договора, проведение несанкционированной коммерческой деятельности с использованием вашего членства и по другим причинам, указанным в пункте 5.'],
                    ['language' => 'en', 'translation' => 'Premium Link Generator can decide to reject your Registration and/or terminate your Membership anytime and for any reason, which include but not limited to: breaching the Agreement, conducting unauthorized commercial activity using your Membership and for other reasons stated in Point 5.'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Отмена членства'],
                    ['language' => 'en', 'translation' => 'Cancellation of Membership'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Если вы не полностью удовлетворены нашими услугами, вы можете отменить ваше членство в любое время. Вы можете либо просто прекратить использование сайта или отправить нам по электронной почте на [указать адрес электронной почты здесь] с вашим запросом. Отмена вашего членства является единственным средством защиты права в отношении любого спора с премией Link Generator.'],
                    ['language' => 'en', 'translation' => 'If you are not completely satisfied with our Services, you may cancel your Membership anytime. You can either simply cease using the site or send us an e-mail to [insert e-mail address here] with your request. Cancellation of your membership is your sole right and remedy regarding any dispute with Premium Link Generator.'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Описание услуг'],
                    ['language' => 'en', 'translation' => 'Description of Services'], 
                ],
                [
                    ['language' => 'ru', 'translation' => 'Премиум Link Generator работает как прокси-сервер, так что пользователи могут загружать и хранить законные файлы, размещенные в облачных сервисов сторонних производителей в высокоскоростном и без необходимости подписываться. Сайт делает все, чтобы предотвратить распространение защищенных авторским правом файлов, используя все доступные технологии и методы, такие как:'],
                    ['language' => 'en', 'translation' => 'Premium Link Generator works like a proxy server so users can download and store legitimate files hosted in third-party cloud services in high-speed and without the need to subscribe. The Site is doing everything to prevent the distribution of copyrighted files by using all available technology and methods, such as:'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Имя фильтра. Если имя файла подлежит права интеллектуальной собственности, а затем загрузку файла допускается.'],
                    ['language' => 'en', 'translation' => 'Name filters. If the file name is subject to intellectual property right then downloading the file is allowed.'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'DMCA Список файлов. Пользователи не могут хранить файлы, которые были включены в список премиум Link Generator, который нарушают DMCA. Примечание: Сайт имеет соответствующую форму, что члены и не члены могут использовать, чтобы сообщить об этих типов файлов.'],
                    ['language' => 'en', 'translation' => 'DMCA File List. Users can’t store files that were included in the list of Premium Link Generator which violate the DMCA. Note: The Site has a relevant form that members and non-members can use to report these kinds of files.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Скачать все с одним аккаунтом'],
                    ['language' => 'en', 'translation' => 'When Premium Link Generator receives a DMCA complaint or detects that a file is subject to copyright, the Site immediately notifies the cloud service where it is stored. The file will be immediately deleted from the website where it is stored so the distribution and sharing of the file will be impossible.'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Когда Премиум Ссылка Генератор получает жалобу о нарушении авторских прав или определяет, что файл является объектом авторского права, Сайт немедленно уведомляет службу облако, где она хранится. Файл будет немедленно удален с сайта, где он хранится, так что распределение и совместное использование файла будет невозможно.'],
                    ['language' => 'en', 'translation' => 'There are also other methods that Premium Link Generator uses to prevent the distribution of copyrighted files. However, these can’t be disclosed publicly so hostile users can’t evade them.Premium Link Generator only operates like a proxy server with private members that can download files. The Site DOES NOT pay anyone to upload or download files. The servers only act as a proxy and DO NOT store any file.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Содержание Член'],
                    ['language' => 'en', 'translation' => 'Member Content'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Загруженные файлы через Сайт членами являются их ответственность и за любые и все последующие использования сгенерированного URL. Перед тем как Скачать сгенерированных URL-адреса, вы должны быть уверены, что у вас есть все основные права собственности и иных прав на них. Пользователи должны согласиться использовать услуги в соответствии с любыми и всеми применимыми законами и правилами <br> Ниже приведен список вещей, которые вы не должны делать в отношении Сгенерированный URL:'],
                    ['language' => 'en', 'translation' => 'The downloaded files through the Site by members are their responsibility and for any and all succeeding uses of the Generated URLs. Before you post Download Generated URLs, you must be sure that you have all the essential ownership and other rights for these. Users must agree to use the Services in accordance with any and all applicable laws and regulations.<br>Below is the list of things that you shouldn’t do regarding the Generated URLs:'],
                ],
                [  
                    ['language' => 'ru', 'translation' => 'Номера Одобрение / нейтральная сторона'],
                    ['language' => 'en', 'translation' => 'Non-Endorsement/Neutral Party'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Любой контент, который может считаться незаконным, вредоносным, угрожающим, клеветническим, непристойным, оскорбительным или иным причинам не должны быть загружены;'],
                    ['language' => 'en', 'translation' => 'Any content that can be considered to be unlawful, harmful, threatening, defamatory, obscene, harassing, or otherwise objectionable shouldn’t be downloaded;'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Счет будет немедленно прекращено, если пользователь загружает любое содержание, которое нарушает какие-либо товарный знак, фирменное наименование, знак обслуживания, лицензию авторских прав или другой интеллектуальной собственности, или право собственности какой-либо третьей стороны;'],
                    ['language' => 'en', 'translation' => 'An account will be immediately terminated if the user downloads any content that violates any trademark, trade name, service mark, copyright license, or other intellectual property, or proprietary right of any third party;'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Персональные данные любого третьего лица не должны быть загружены в том числе номера телефонов, адреса, фамилии, URL-адресов и адресов электронной почты;'],
                    ['language' => 'en', 'translation' => 'Personally identifiable information of any third-person shouldn’t be downloaded including telephone numbers, street addresses, last names, URLs, and e-mail addresses;'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Без предварительного разрешения, пользователи не должны загружать любые звуковые файлы, текст, фотографии, видео и другие изображения, содержащие конфиденциальную информацию;'],
                    ['language' => 'en', 'translation' => 'Without prior authorization, users shouldn’t download any audio files, text, photographs, videos, and other images containing confidential information;'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Непристойные файлы, которые определяются в соответствии с действующим законодательством, в том числе аудио-файлы, текст, фотографии или другие изображения не должны быть загружены;'],
                    ['language' => 'en', 'translation' => 'Obscene files, which are defined under applicable law, including audio files, text, photographs, or other images shouldn’t be downloaded;'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Пользователи не должны выражать или подразумевать, что любой из их заявления были одобрены Премиум Link Generator или без специального письменного согласия;'],
                    ['language' => 'en', 'translation' => 'Users should never express or imply that any of their statements were endorsed by Premium Link Generator without or specific written consent;'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Без согласия, пользователи не могут собирать личную информацию о конечных пользователей или третьих лиц;'],
                    ['language' => 'en', 'translation' => 'Without consent, users can’t collect personal information about end-users or other third parties;'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Пользователи не должны получить, индекс, или каким-либо образом воспроизводить или обходить навигационную структуру Сайта, Услуг или связанных с содержанием с использованием роботов, паук, поиск по сайту / приложение поиска или другого ручного или автоматического устройства;'],
                    ['language' => 'en', 'translation' => 'Users should never retrieve, index, or in any way reproduce or by-pass the navigational structure of the Site, Services, or related content using any robot, spider, site search/retrieval application, or other manual or automatic device;'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Службы, сайт и / или сервер и / или сети, подключенные никогда не должны быть прерваны или уничтожены пользователями;'],
                    ['language' => 'en', 'translation' => 'The Services, the Site, and/or the server and/or networks connected should never be interrupted or destroy by the users;'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Программное обеспечение, которое содержит вирусы или другие компьютерные коды, файлы или программы, предназначенные для разрушения, повреждения или ограничения функциональности любого компьютерного программного или аппаратного обеспечения или телекоммуникационного оборудования, не должны быть размещены, предложение для загрузки, электронной почте или иным образом передавать любые материалы ;'],
                    ['language' => 'en', 'translation' => 'Software that contains viruses or other computer code, files, or programs designed to disrupt, damage, or limit the functionality of any computer software or hardware or telecommunications equipment shouldn’t be posted, offer for download, e-mail or otherwise transmit any material;'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Шпионского и рекламного ПО, а также другие программы, предназначенные для рассылки нежелательной рекламы услуг, не должны быть размещены, предложение для загрузки, передавать, рекламировать или распространять любое программное обеспечение, продукты или услуги, которые являются незаконными или нарушает права третьей стороны , Это программное обеспечение предназначено для инициирования "отказ в обслуживании" атак, программ почтовая бомба, и другие программы, разработанные для проникновения доступа к сети Интернет;'],
                    ['language' => 'en', 'translation' => 'Spyware, adware, and other programs designed to send unsolicited advertisements services shouldn’t be posted, offer for download, transmit, promote, or make available any software, products, or services that are illegal or that violates the rights of a third-party. This software is designed to initiate ‘denial of service’ attacks, mail bomb programs, and other programs designed to infiltrate access to networks on the internet;'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Любая часть Сайта и / или услуг, не должно быть "кадр" или "зеркало" без Генераторы Премиум Ссылка письменного согласия;'],
                    ['language' => 'en', 'translation' => 'Any part of the Site and/or Services shouldn’t be ‘frame’ or ‘mirror’ without Premium Link Generator’s written consent;'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Немедленное прекращение счета и распространение деталей членов властям будет сделано в случае, если кто-то использует наши услуги для контента, которые могут быть сочтены оскорбительными для детей или незаконной порнографии;'],
                    ['language' => 'en', 'translation' => 'Immediate account termination and spreading of member details to the authorities will be done in case someone uses our services for content that can be considered abusive to children or illegal pornography;'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Любая часть Сайта и / или услуги не должны быть изменены, приспособлены, сублицензии, переводить, продавать, перепроектируете, расшифровать, декомпилировать или иным образом демонтирует;'],
                    ['language' => 'en', 'translation' => 'Any part of the Site and/or Service shouldn’t be modified, adapted, sublicensed, translated, sell, reverse engineer, decipher, decompile, or otherwise disassemble;'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Сформированные URL-адреса могут быть использованы только владельцем Премиум Link Generator счета. Это не разрешается размещать или поделиться ими с кем-либо и работает только с учетной записью, создавшего them.If пользователь был обнаружен нарушение любого из этих методов, то он будет считаться как нарушение Договора и счет будет немедленно прекращено без уведомления , Премиум Ссылка Генератор имеет право делать любые юридические действия в отношении членов, которые будут нарушать раздел Content-члены.'],
                    ['language' => 'en', 'translation' => 'Generated URLs can only be used by the owner of Premium Link Generator account. It’s not allowed to post or share these with anyone and only works with the account that generated them.If a user was found violating any of these practices, it will be deemed as a breach of the Agreement and the account will be immediately terminated without notice. Premium Link Generator has the right to do any legal action against members that will violate the Member Content section.'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Премиум Link Generator работает сайта и услуги в качестве нейтральной стороны. Таким образом, сайт не регулярно контролировать, регулировать или следить за использование Сайта и / или Услуг любым из его членов. Тем не менее, это не означает, что Премиум Link Generator одобрить любую деятельность членов. Сайт не несет ответственности за члена или иных действий стороннего, упущения соглашений, обещаний, ссылки контента, другие продукты, услуги, комментарии, мнения, советы, заявления, предложения и / или другой информации, представленной.'],
                    ['language' => 'en', 'translation' => 'Premium Link Generator works the Site and Services as a neutral party. Thus, the Site doesn’t regularly monitor, regulate, or watch the use of the Site and/or Services by any of its Members. However, it doesn’t mean that Premium Link Generator endorse any activity of the Members. The Site is not responsible for the Member or other third-party’s acts, omissions, agreements, promises, content links, other products, services, comments, opinions, advice, statements, offers, and/or other information made available.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'права собственности'],
                    ['language' => 'en', 'translation' => 'Proprietary Rights'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Link Generator Премиум защищена в соответствии с применимыми авторскими правами, торговыми марками, а также другие имущественные права, такие, как его содержание, организация, графика, дизайн, компиляция, магнитный перевод, цифровое преобразование, программное обеспечение, услуги и другие вопросы. Таким образом, строго запрещается копировать, распространять, публиковать или любую часть премиум Link Generator. Пользователи не приобретают права собственности на какой-либо части премиум Link Generator посмотреть на сайте или через сайт.'],
                    ['language' => 'en', 'translation' => 'The Premium Link Generator is protected under applicable copyrights, trademarks, and other proprietary rights, such as its content, organization, graphics, design, compilation, magnetic translation, digital conversion, software, services, and other matters. Thus, it is strictly prohibited to copy, redistribute, or publish any part of Premium Link Generator. Users do not acquire ownership rights to any part of Premium Link Generator viewed at or through the Site.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Юридическое предупреждение'],
                    ['language' => 'en', 'translation' => 'Legal Warning'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Попытка повредить, уничтожить, фальсифицировать, хулиганить, и / или мешать работе Сайта и / или Услуг является нарушением уголовного и гражданского права. Премиум Ссылка Генератор будет проводить юридические действия в отношении физического или юридического лица в полном объеме, утвержденной законом и справедливости.'],
                    ['language' => 'en', 'translation' => 'Attempt to damage, destroy, tamper with, vandalize, and/or interfere with the operation of the Site and/or Services is a violation of criminal and civil law. Premium Link Generator will pursue legal actions against individual or entity to the fullest extent approved by the law and in equity.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Премиум'],
                    ['language' => 'en', 'translation' => 'Premium Membership Fees'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'При регистрации для наших дополнительных услуг и использовать любой способ оплаты, ваш счет будет взиматься соответствующую сумму на основе того, что вы выбираете. Все расходы выставляются в долларах США. Если члены не хотят использовать Премиум услуги, это не означает, что они отказываются платить какой-либо из сборов.'],
                    ['language' => 'en', 'translation' => 'When you register for our Premium Services and use any method of payment, your account will be charged the applicable amount based on what you choose. All charges are billed in U.S. Dollars. If members don’t want to use Premium Services, it doesn’t mean that they refuse to pay any of the fees.'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Сайты третьих лиц'],
                    ['language' => 'en', 'translation' => 'Third Party Websites'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Премиум Link Generator содержит ссылки на другие веб-сайты в Интернете, которые принадлежат и управляются третьими лицами. Заметим, что включение всех этих ссылок не означает, что сайт поддерживает эти сторонние веб-сайты или имеет какую-либо связь с операторами веб-сайтов. Сайт не имеет никакого контроля над информацией, продукции или услуг на этих сторонних веб-сайтах. Таким образом, пользователи соглашаются, что Премиум Link Generator не может быть привлечен к ответственности или ответственности за доступность или эксплуатации этих сторонних сайтов. Любой вид сделки, сделки, участия, предлагаемых на сайте рекламодателя включая оплату и доставку соответствующих товаров или услуг, или любые другие условия, условия, гарантии или представления, связанные с операциями, являются исключительно между вами и соответствующего веб-сайта третьей стороны. Премиум Link Generator не несет ответственности, прямо или косвенно, за любые убытки или ущерб, причиненный продукции или услуг, приобретаемых пользователем с любого веб-сайта третьей стороны.'],
                    ['language' => 'en', 'translation' => 'Premium Link Generator contains a link to other websites on the internet, which are owned and operated by third parties. Note that the inclusion of all these links doesn’t imply that the Site endorses these third-party websites or has any association with the website operators. The Site has no control over the information, products, or services on these third-party websites. Thus, users agree that Premium Link Generator can’t be held liable or responsible for the availability or the operation of these third-party sites. Any kind of transaction, dealings, participations offered on the advertiser’s site including payment and delivery of related products or service, or any other terms, conditions, warranties, or representations associated with the transactions are solely between you and the applicable third-party website. Premium Link Generator shall not be responsible, directly or indirectly, for any loss or damages caused by the products or services purchased by the user from any third-party website.'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Отказ от гарантийных обязательств'],
                    ['language' => 'en', 'translation' => 'Disclaimer of Warranties'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'НА ОСНОВЕ ИЗ НАСКОЛЬКО ЭТО РАЗРЕШЕНО ДЕЙСТВУЮЩИМ ЗАКОНОДАТЕЛЬСТВОМ (ВКЛЮЧАЯ, НО НЕ ОГРАНИЧИВАЯСЬ, ОТКАЗ ОТ ГАРАНТИЙ КОММЕРЧЕСКОЙ НЕНАРУШЕНИЯ ИНТЕЛЛЕКТУАЛЬНОЙ СОБСТВЕННОСТИ, И / ИЛИ ПРИГОДНОСТИ ДЛЯ КОНКРЕТНЫХ ЦЕЛЕЙ), сайт, услуги, сгенерированные URLы и  ИЛИ ЛЮБЫЕ ИЗДЕЛИЯ И  ИЛИ УСЛУГИ, ПРЕДОСТАВЛЯЕМЫЕ НА САЙТЕ ПРЕДОСТАВЛЯЮТСЯ ПОЛЬЗОВАТЕЛЕЙ НА УСЛОВИИ КАК ЕСТЬ И КАК ДОСТУПНО. PREMIUM LINK ГЕНЕРАТОР НЕ ГАРАНТИРУЕТ, ЧТО ВЕБ САЙТ, УСЛУГИ, сгенерированные URLы и  или любых других продуктов и / или услуг, предлагаемых на сайте ВОЛИ:'],
                    ['language' => 'en', 'translation' => 'BASED FROM THE FULLEST EXTENT PERMITTED BY APPLICABLE LAW (INCLUDING, BUT NOT LIMITED TO, DISCLAIMER OF WARRANTIES OF MERCHANTABILITY, NON-INFRINGEMENT OF INTELLECTUAL PROPERTY, AND/OR FITNESS FOR A PARTICULAR PURPOSE), THE SITE, SERVICES, GENERATED URLS, AND/OR ANY PRODUCTS AND/OR SERVICES OFFERED ON THE SITE ARE PROVIDED TO USERS ON AN ‘AS IS’ AND ‘AS AVAILABLE’. PREMIUM LINK GENERATOR CAN’T GUARANTEE THAT THE SITE, SERVICES, GENERATED URLS, AND/OR ANY OTHER PRODUCTS AND/OR SERVICES OFFERED ON THE SITE WILL:'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Удовлетворения пользователей требований;'],
                    ['language' => 'en', 'translation' => 'MEET USER’S REQUIREMENTS;'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'НЕПРЕРЫВНО, БЕЗОПАСНО ИЛИ БЕЗ ОШИБОК ИЛИ ЧТО ДЕФЕКТЫ БУДУТ ИСПРАВЛЕНЫ;'],
                    ['language' => 'en', 'translation' => 'BE UNINTERRUPTED, TIMELY, SECURE, OR ERROR-FREE OR THAT DEFECTS WILL BE CORRECTED;'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'ВИРУСОВ ИЛИ ДРУГИХ ВРЕДНЫХ СОДЕРЖАНИЕ;'],
                    ['language' => 'en', 'translation' => 'FREE OF VIRUSES OR OTHER HARMFUL CONTENTS;'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Методы обеспечения безопасности, которые будут достаточно, чтобы обеспечить ОСУЩЕСТВЛЕНИЮ С ИСПОЛЬЗОВАНИЕМ САЙТА ИЛИ БОРЬБЫ нарушения; И / ИЛИ'],
                    ['language' => 'en', 'translation' => 'SECURITY METHODS THAT WILL BE ENOUGH TO PROVIDE ENJOYMENT WITH THE USE OF THE SITE OR FIGHT AGAINST INFRINGEMENT; AND/OR'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'ТОЧНЫМИ ИЛИ НАДЕЖНЫМИ.'],
                    ['language' => 'en', 'translation' => 'ACCURATE OR RELIABLE.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'ЛЮБОЕ СОДЕРЖАНИЕ, СВЯЗАННЫЕ С НА САЙТЕ МОЖЕТ СОДЕРЖАТЬ ОШИБОК, проблемы, или другие ограничения. Кроме того, САЙТ НЕ НЕСЕТ ОТВЕТСТВЕННОСТИ ЗА НАЛИЧИИ ПОДСТИЛАЮЩЕЙ ИНТЕРНЕТ, относящиеся к сайту, УСЛУГИ И / ИЛИ сгенерированные URLы. Либо, что пользователь получить с сайта НЕ ДОЛЖНО СОЗДАТЬ ГАРАНТИЙ, если это не было указано в договоре.'],
                    ['language' => 'en', 'translation' => 'ANY CONTENT RELATED ON THE SITE MAY CONTAIN BUGS, ERRORS, PROBLEMS, OR OTHER LIMITATIONS. MOREOVER, THE SITE IS NOT RESPONSIBLE FOR THE AVAILABILITY OF THE UNDERLYING INTERNET CONNECTION RELATED TO THE SITE, SERVICES, AND/OR GENERATED URLS. ANYTHING THAT USERS OBTAINED FROM THE SITE SHALL NOT CREATE WARRANTY UNLESS IT WAS STATED IN THE AGREEMENT.'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Ограничение ответственности'],
                    ['language' => 'en', 'translation' => 'Limitations of Liability'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'PREMIUM LINK ГЕНЕРАТОР НЕ НЕСУТ НАПРЯМУЮ, КОСВЕННО, кстати, СПЕЦИАЛЬНО, как следствие, И / ИЛИ ТИПОВЫЕ к пользователям или любой третьей стороной за любые убытки, ПОТЕРИ ПРИБЫЛИ, РЕПУТАЦИИ, ИСПОЛЬЗОВАНИЯ, ДАННЫХ ИЛИ ДРУГИЕ НЕМАТЕРИАЛЬНЫЕ УБЫТКИ (ДАЖЕ ЕСЛИ PREMIUM LINK ГЕНЕРАТОР БЫЛИ ПРЕДУПРЕЖДЕНЫ О ВОЗМОЖНОСТИ ТАКОГО УЩЕРБА) В ПОЛНОЙ МЕРЕ, РАЗРЕШЕННОЙ ЗАКОНОМ ПО:'],
                    ['language' => 'en', 'translation' => 'PREMIUM LINK GENERATOR SHALL NOT BE LIABLE DIRECTLY, INDIRECTLY, INCIDENTALLY, SPECIALLY, CONSEQUENTIALLY, AND/OR EXEMPLARY TO THE USERS OR ANY THIRD-PARTY FOR ANY DAMAGES, LOSS OF PROFITS, GOODWILL, USE, DATA, OR OTHER INTANGIBLE LOSSES (EVEN IF PREMIUM LINK GENERATOR HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES) TO THE FULLEST EXTENT PERMITTED BY THE LAW FOR:'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'ИСПОЛЬЗОВАНИЯ ИЛИ НЕВОЗМОЖНОСТИ ИСПОЛЬЗОВАНИЯ САЙТА, УСЛУГИ, сгенерированные URLы И / ИЛИ любой другой продукции и / или услуг, предлагаемых на сайте'],
                    ['language' => 'en', 'translation' => 'THE USE OR THE INABILITY TO USE THE SITE, SERVICES, GENERATED URLS AND/OR ANY OTHER PRODUCTS AND/OR SERVICES OFFERED ON THE SITE'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'СТОИМОСТЬ ЗАМЕНОЙ ТОВАРОВ И УСЛУГ В РЕЗУЛЬТАТЕ ЛЮБЫХ ТОВАРОВ, ДАННЫХ, ИНФОРМАЦИИ, содержание и / или любых других продуктов, купленных или полученных ОТ ИЛИ ЧЕРЕЗ САЙТ;'],
                    ['language' => 'en', 'translation' => 'THE COST OF OBTAINING SUBSTITUTE GOODS AND SERVICES RESULTING FROM ANY GOODS, DATA, INFORMATION, CONTENT AND/OR ANY OTHER PRODUCTS PURCHASED OR OBTAINED FROM OR THROUGH THE SITE;'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Несанкционированный ДОСТУП К, ИЛИ ИЗМЕНЕНИЯ, регистрационные данные; А ТАКЖЕ'],
                    ['language' => 'en', 'translation' => 'THE UNAUTHORIZED ACCESS TO, OR ALTERATION OF, YOUR REGISTRATION DATA; AND'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'ЛЮБОЙ ДРУГОЙ ВОПРОС УЧАСТИЕМ на сайт, УСЛУГИ, сгенерированные URLы И / ИЛИ любых других продуктов и / или услуг, предлагаемых на сайте.'],
                    ['language' => 'en', 'translation' => 'ANY OTHER ISSUE INVOLVING TO THE SITE, SERVICES, GENERATED URLS AND/OR ANY OTHER PRODUCTS AND/OR SERVICES OFFERED ON THE SITE.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'ВСЕ ОГРАНИЧЕНИЯ ЗАЯВИЛ относится, НО НЕ ОГРАНИЧИВАЯСЬ НАРУШЕНИЯ ДОГОВОРА, НАРУШЕНИЯ ГАРАНТИИ, ХАЛАТНОСТИ, СТРОГОЙ ОТВЕТСТВЕННОСТИ, ЗАБЛУЖДЕНИЕ, а также всех других правонарушений. PREMIUM LINK ГЕНЕРАТОР Выйдет от любых обязательств, обязательств, а также ПРЕТЕНЗИЙ СВЕРХ ОГРАНИЧЕНИЙ ИЗЛОЖЕННЫХ. После одного (1) года после события, ВЫ ИЛИ САЙТ НЕ МОГУТ ними любые действия в отношении вопроса, вытекающими из ИСПОЛЬЗОВАНИЯ САЙТА, УСЛУГ, сгенерированные URLы И / ИЛИ любые другие продукты и / или услуги, предлагаемые на САЙТ. БЕЗ ДАННЫМИ ОГРАНИЧЕНИЯМИ ДОСТУПА САЙТА, УСЛУГ, сгенерированные URLы, И / ИЛИ любых других продуктов и / или услуг, предлагаемых на сайте не предоставляется пользователям. ПРИМЕЧАНИЕ: НЕКОТОРЫЕ ЮРИСДИКЦИИ НЕ ПОЗВОЛЯЮТ ОПРЕДЕЛЕННЫЕ ОГРАНИЧЕНИЯ ОТВЕТСТВЕННОСТИ. ТАКИМ, PREMIUM LINK ГЕНЕРАТОР ОТВЕТСТВЕННОСТЬ НЕСЕТ ОГРАНИЧИВАЕТСЯ МАКСИМАЛЬНО РАЗРЕШЕННЫХ ЗАКОНОМ.'],
                    ['language' => 'en', 'translation' => 'ALL OF THE LIMITATION STATED APPLIES, BUT NOT LIMITED TO, THE BREACH OF CONTRACT, BREACH OF WARRANTY, NEGLIGENCE, STRICT LIABILITY, MISREPRESENTATION, AND ANY AND ALL OTHER OFFENSES. PREMIUM LINK GENERATOR WILL BE RELEASED FROM ANY AND ALL OBLIGATIONS, LIABILITIES, AND CLAIMS IN EXCESS OF THE LIMITATIONS STATED. AFTER ONE (1) YEAR FOLLOWING THE EVENT, YOU OR THE SITE CAN’T DO ANY ACTION REGARDING THE ISSUE THAT AROSE OUT OF YOUR USE OF THE SITE, SERVICES, GENERATED URLS AND/OR ANY OTHER PRODUCTS AND/OR SERVICES OFFERED ON THE SITE. WITHOUT THESE LIMITATIONS, THE ACCESS OF THE SITE, SERVICES, GENERATED URLS, AND/OR ANY OTHER PRODUCTS AND/OR SERVICES OFFERED ON THE SITE WILL NOT BE PROVIDED TO USERS. NOTE: SOME JURISDICTIONS DO NOT ALLOW CERTAIN LIMITATIONS ON LIABILITY. THUS, PREMIUM LINK GENERATOR LIABILITY SHALL BE LIMITED TO THE MAXIMUM EXTENT PERMITTED BY THE LAW.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Редактирование, удаление и модификация'],
                    ['language' => 'en', 'translation' => 'Editing, Deleting, and Modification'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Любой контент, документы, информация или другие материалы, которые можно увидеть на сайте, могут быть отредактированы и / или удалены с генераторами Премиум Link правом и усмотрению.'],
                    ['language' => 'en', 'translation' => 'Any content, documents, information, or other materials that can be seen on the Site, can be edited and/or deleted with Premium Link Generator’s right and sole discretion.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'информация о пользователе'],
                    ['language' => 'en', 'translation' => 'User Information'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Любой из материалов, которые пользователи отправляют или связанные с сайтом, в том числе, но не ограничиваясь ими, регистрационные данные, должны быть подвергнуты политике конфиденциальности. Вы можете ознакомиться с политикой конфиденциальности, используя ссылку ниже или нажмите здесь {privacy_link}.'],
                    ['language' => 'en', 'translation' => 'Any of the materials that users submit or associated with the Site including, but not limited to, the Registration Data, shall be subjected to the Privacy Policy. You can read the Privacy Policy using the link below or click here {privacy_link}.'],
                ],
                [
                    ['language' => 'ru', 'translation' => 'Как связаться с нами'],
                    ['language' => 'en', 'translation' => 'How to Contact Us'],
                ], 
                [
                    ['language' => 'ru', 'translation' => 'Если у вас есть какие-либо вопросы или сомнения по поводу договора или методов премиум Link Generator, не стесняйтесь связаться с нами здесь {link} Контакты США'],
                    ['language' => 'en', 'translation' => 'If you have any queries or concerns regarding the Agreement or the methods of Premium Link Generator do not hesitate to contact us here {link} Contact US'],
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
        echo "m161110_090204_seed_terms_translation_data cannot be reverted.\n";

        return false;
    }

}
