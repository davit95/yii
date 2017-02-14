<?php

use yii\db\Migration;
use yii\db\Query;
use yii\db\Command;
use yii\db\Connection;

class m161201_093826_remove_hosts_duplicates extends Migration
{
    public function up()
    {
        Yii::$app->db->createCommand()->truncateTable('{{%hosts}}')->execute();

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //Add sample data

        $this->insert('{{%hosts}}', [
            'name'=>'1fichier.com',
            'logo' => '1fichier.png',
            'logo_monochrome' => '1fichier_mono.png',
            'logo_small' => '1fichier_small.png',
            'logo_large' => '1fichier_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'1 €',
            'host_url'=>'https://1fichier.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'filesflash.com',
            'logo' => 'filesflash.png',
            'logo_monochrome' => 'filesflash_mono.png',
            'logo_small' => 'filesflash_small.png',
            'logo_large' => 'filesflash_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'1 €',
            'host_url'=>'http://filesflash.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'junocloud.me',
            'logo' => 'junocloud.png',
            'logo_monochrome' => 'junocloud_mono.png',
            'logo_small' => 'junocloud_small.png',
            'logo_large' => 'junocloud_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'8.89 €',
            'host_url'=>'http://junocloud.me/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'hugefiles.net',
            'logo' => 'hugefiles.png',
            'logo_monochrome' => 'hugefiles_mono.png',
            'logo_small' => 'hugefiles_small.png',
            'logo_large' => 'hugefiles_large.png',
            'max_mb_per_day'=>'0',
            'download_options'=>'1 website',
            'pricing'=>'0',
            'host_url'=>'http://hugefiles.net'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'fileload.io',
            'logo' => 'fileload.png',
            'logo_monochrome' => 'fileload_mono.png',
            'logo_small' => 'fileload_small.png',
            'logo_large' => 'fileload_large.png',
            'max_mb_per_day'=>'25 GB',
            'download_options'=>'1 website',
            'pricing'=>'4,99 €',
            'host_url'=>'https://fileload.io/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'nosvideo.com',
            'logo' => 'nosvideo.png',
            'logo_monochrome' => 'nosvideo_mono.png',
            'logo_small' => 'nosvideo_small.png',
            'logo_large' => 'nosvideo_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'No Price',
            'host_url'=>'http://novafile.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'novafile.com',
            'logo' => 'novafile.png',
            'logo_monochrome' => 'novafile_mono.png',
            'logo_small' => 'novafile_small.png',
            'logo_large' => 'novafile_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'9.95 $ + Tax 21%',
            'host_url'=>'http://novafile.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'share-online.biz',
            'logo' => 'share-online.png',
            'logo_monochrome' => 'share-online_mono.png',
            'logo_small' => 'share-online_small.png',
            'logo_large' => 'share-online_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'9.49 €',
            'host_url'=>'http://www.share-online.biz/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'lafiles.com',
            'logo' => 'lafiles.png',
            'logo_monochrome' => 'lafiles_mono.png',
            'logo_small' => 'lafiles_small.png',
            'logo_large' => 'lafiles_large.png',
            'max_mb_per_day'=>'20 GB in 3 days',
            'download_options'=>'1 website',
            'pricing'=>'$13.99',
            'host_url'=>'http://lafiles.com/?op=login'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'usercloud.com',
            'logo' => 'usercloud.png',
            'logo_monochrome' => 'usercloud_mono.png',
            'logo_small' => 'usercloud_small.png',
            'logo_large' => 'usercloud_large.png',
            'max_mb_per_day'=>'0',
            'download_options'=>'1 website',
            'pricing'=>'0',
            'host_url'=>'http://usercloud.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'foxupload.online',
            'logo' => 'foxupload.png',
            'logo_monochrome' => 'foxupload_mono.png',
            'logo_small' => 'foxupload_small.png',
            'logo_large' => 'foxupload_large.png',
            'max_mb_per_day'=>'0',
            'download_options'=>'1 website',
            'pricing'=>'0',
            'host_url'=>'https://foxupload.online/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'mediafire.com',
            'logo' => 'mediafire.png',
            'logo_monochrome' => 'mediafire_mono.png',
            'logo_small' => 'mediafire_small.png',
            'logo_large' => 'mediafire_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'50.00 $ / month',
            'host_url'=>'https://www.mediafire.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'nitroflare.com',
            'logo' => 'nitroflare.png',
            'logo_monochrome' => 'nitroflare_mono.png',
            'logo_small' => 'nitroflare_small.png',
            'logo_large' => 'nitroflare_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'12.00 $',
            'host_url'=>'http://nitroflare.com/'
        ]);
        
           $this->insert('{{%hosts}}', [
            'name' => 'cloudsix.me',
            'logo' => 'cloudsix.png',
            'logo_monochrome' => 'cloudsix_mono.png',
            'logo_small' => 'cloudsix_small.png',
            'logo_large' => 'cloudsix_large.png',
            'max_mb_per_day'=>'unlimited',
            'download_options'=>'1 website',
            'pricing'=>'$19.95',
            'host_url'=>'http://cloudsix.me/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'upasias.com',
            'logo' => 'upasias.png',
            'logo_monochrome' => 'upasias_mono.png',
            'logo_small' => 'upasias_small.png',
            'logo_large' => 'upasias_large.png',
            'max_mb_per_day'=>'24 GB in 3 days',
            'download_options'=>'1 website',
            'pricing'=>'12.99 $',
            'host_url'=>'http://upasias.com/?op=login'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'solidfiles.com',
            'logo' => 'solidfiles.png',
            'logo_monochrome' => 'solidfiles_mono.png',
            'logo_small' => 'solidfiles_small.png',
            'logo_large' => 'solidfiles_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'9.99 €',
            'host_url'=>'https://www.solidfiles.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'upstore.net',
            'logo' => 'upstore.png',
            'logo_monochrome' => 'upstore_mono.png',
            'logo_small' => 'upstore_small.png',
            'logo_large' => 'upstore_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'11.95€',
            'host_url'=>'https://upstore.net/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'rapidfileshare.net',
            'logo' => 'rapidfileshare.png',
            'logo_monochrome' => 'rapidfileshare_mono.png',
            'logo_small' => 'rapidfileshare_small.png',
            'logo_large' => 'rapidfileshare_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'10 $',
            'host_url'=>'http://www.rapidfileshare.net/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'florenfile.com',
            'logo' => 'florenfile.png',
            'logo_monochrome' => 'florenfile_mono.png',
            'logo_small' => 'florenfile_small.png',
            'logo_large' => 'florenfile_large.png',
            'max_mb_per_day'=>'20 GB in 3 days',
            'download_options'=>'1 website',
            'pricing'=>'9.95 $',
            'host_url'=>'http://florenfile.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'depfile.com',
            'logo' => 'depfile.png',
            'logo_monochrome' => 'depfile_mono.png',
            'logo_small' => 'depfile_small.png',
            'logo_large' => 'depfile_large.png',
            'max_mb_per_day'=>'download_options',
            'download_options'=>'1 website',
            'pricing'=>'19.95 $',
            'host_url'=>'http://depfile.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'daofile.com',
            'logo' => 'daofile.png',
            'logo_monochrome' => 'daofile_mono.png',
            'logo_small' => 'daofile_small.png',
            'logo_large' => 'daofile_large.png',
            'max_mb_per_day'=>'0',
            'download_options'=>'1 website',
            'pricing'=>'0',
            'host_url'=>'http://daofile.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'redbunker.net',
            'logo' => 'redbunker.png',
            'logo_monochrome' => 'redbunker_mono.png',
            'logo_small' => 'redbunker_small.png',
            'logo_large' => 'redbunker_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'14.99 $',
            'host_url'=>'http://redbunker.net/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'mediafree.co',
            'logo' => 'mediafree.png',
            'logo_monochrome' => 'mediafree_mono.png',
            'logo_small' => 'mediafree_small.png',
            'logo_large' => 'mediafree_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'5.00 $',
            'host_url'=>'http://mediafree.co/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'secureupload.eu',
            'logo' => 'secureupload.png',
            'logo_monochrome' => 'secureupload_mono.png',
            'logo_small' => 'secureupload_small.png',
            'logo_large' => 'secureupload_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'12.99 USD',
            'host_url'=>'https://secureupload.eu/login'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'bitvid.sx',
            'logo' => 'bitvid.png',
            'logo_monochrome' => 'bitvid_mono.png',
            'logo_small' => 'bitvid_small.png',
            'logo_large' => 'bitvid_large.png',
            'max_mb_per_day'=>'3 cents per day',
            'download_options'=>'1 website',
            'pricing'=>'10 $',
            'host_url'=>'http://www.bitvid.sx/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'rapidgator.net',
            'logo' => 'rapidgator.png',
            'logo_monochrome' => 'rapidgator_mono.png',
            'logo_small' => 'rapidgator_small.png',
            'logo_large' => 'rapidgator_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'14.99 $',
            'host_url'=>'http://rapidgator.net/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'hitfile.net',
            'logo' => 'hitfile.png',
            'logo_monochrome' => 'hitfile_mono.png',
            'logo_small' => 'hitfile_small.png',
            'logo_large' => 'hitfile_large.png',
            'max_mb_per_day'=>'unlimited',
            'download_options'=>'1 website',
            'pricing'=>'9.95 $',
            'host_url'=>'http://hitfile.net/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'anafile.com',
            'logo' => 'anafile.png',
            'logo_monochrome' => 'anafile_mono.png',
            'logo_small' => 'anafile_small.png',
            'logo_large' => 'anafile_large.png',
            'max_mb_per_day'=>'unlimited',
            'download_options'=>'1 website',
            'pricing'=>'5.00 $',
            'host_url'=>'http://anafile.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'megacache.net',
            'logo' => 'megacache.png',
            'logo_monochrome' => 'megacache_mono.png',
            'logo_small' => 'megacache_small.png',
            'logo_large' => 'megacache_large.png',
            'max_mb_per_day'=>'0',
            'download_options'=>'1 website',
            'pricing'=>'0',
            'host_url'=>'http://megacache.net'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'gboxes.com',
            'logo' => 'gboxes.png',
            'logo_monochrome' => 'gboxes_mono.png',
            'logo_small' => 'gboxes_small.png',
            'logo_large' => 'gboxes_large.png',
            'max_mb_per_day'=>'0',
            'download_options'=>'1 website',
            'pricing'=>'0',
            'host_url'=>'http://www.gboxes.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => '2shared.com',
            'logo' => '2shared.png',
            'logo_monochrome' => '2shared_mono.png',
            'logo_small' => '2shared_small.png',
            'logo_large' => '2shared_large.png',
            'max_mb_per_day'=>'200 mb',
            'download_options'=>'1 website',
            'pricing'=>'free',
            'host_url'=>'http://www.2shared.com/'
        ]);

           $this->insert('{{%hosts}}', [
            'name' => 'clicknupload.link',
            'logo' => 'clicknupload.png',
            'logo_monochrome' => 'clicknupload_mono.png',
            'logo_small' => 'clicknupload_small.png',
            'logo_large' => 'clicknupload_large.png',
            'max_mb_per_day'=>'0',
            'download_options'=>'1 website',
            'pricing'=>'0',
            'host_url'=>'https://clicknupload.link/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'openload.co',
            'logo' => 'openload.png',
            'logo_monochrome' => 'openload_mono.png',
            'logo_small' => 'openload_small.png',
            'logo_large' => 'openload_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'free',
            'host_url'=>'https://openload.co/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'kingfiles.net',
            'logo' => 'kingfiles.png',
            'logo_monochrome' => 'kingfiles_mono.png',
            'logo_small' => 'kingfiles_small.png',
            'logo_large' => 'kingfiles_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'3.00 $',
            'host_url'=>'http://kingfiles.net/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'tusfiles.net',
            'logo' => 'tusfiles.png',
            'logo_monochrome' => 'tusfiles_mono.png',
            'logo_small' => 'tusfiles_small.png',
            'logo_large' => 'tusfiles_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'9.99 €',
            'host_url'=>'https://tusfiles.net/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'filejoker.net',
            'logo' => 'filejoker.png',
            'logo_monochrome' => 'filejoker_mono.png',
            'logo_small' => 'filejoker_small.png',
            'logo_large' => 'filejoker_large.png',
            'max_mb_per_day'=>'unlimited',
            'download_options'=>'1 website',
            'pricing'=>'9.95 $',
            'host_url'=>'https://filejoker.net/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'alfafile.net',
            'logo' => 'alfafile.png',
            'logo_monochrome' => 'alfafile_mono.png',
            'logo_small' => 'alfafile_small.png',
            'logo_large' => 'alfafile_large.png',
            'max_mb_per_day'=>'50 gb',
            'download_options'=>'1 website',
            'pricing'=>'14.99 $',
            'host_url'=>'http://alfafile.net/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'turbobit.net',
            'logo' => 'turbobit.png',
            'logo_monochrome' => 'turbobit_mono.png',
            'logo_small' => 'turbobit_small.png',
            'logo_large' => 'turbobit_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'9.95 €',
            'host_url'=>'http://turbobit.net/'
        ]);
        //
             $this->insert('{{%hosts}}', [
            'name' => 'upload.cd',
            'logo' => 'upload.png',
            'logo_monochrome' => 'upload_mono.png',
            'logo_small' => 'upload_small.png',
            'logo_large' => 'upload_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'$15.99',
            'host_url'=>'http://upload.cd/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'wipfiles.net',
            'logo' => 'wipfiles.png',
            'logo_monochrome' => 'wipfiles_mono.png',
            'logo_small' => 'wipfiles_small.png',
            'logo_large' => 'wipfiles_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'$12.95',
            'host_url'=>'http://wipfiles.net/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'keep2share.cc',
            'logo' => 'keep2share.png',
            'logo_monochrome' => 'keep2share_mono.png',
            'logo_small' => 'keep2share_small.png',
            'logo_large' => 'keep2share_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'4.95 $',
            'host_url'=>'http://keep2share.cc/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'datafile.com',
            'logo' => 'datafile.png',
            'logo_monochrome' => 'datafile_mono.png',
            'logo_small' => 'datafile_small.png',
            'logo_large' => 'datafile_large.png',
            'max_mb_per_day'=>'0.5 $ per day',
            'download_options'=>'1 website',
            'pricing'=>'14.99 $',
            'host_url'=>'http://www.datafile.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'doraupload.com',
            'logo' => 'doraupload.png',
            'logo_monochrome' => 'doraupload_mono.png',
            'logo_small' => 'doraupload_small.png',
            'logo_large' => 'doraupload_large.png',
            'max_mb_per_day'=>'unlimited',
            'download_options'=>'1 website',
            'pricing'=>'10.85 $',
            'host_url'=>'http://doraupload.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'subyshare.com',
            'logo' => 'subyshare.png',
            'logo_monochrome' => 'subyshare_mono.png',
            'logo_small' => 'subyshare_small.png',
            'logo_large' => 'subyshare_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'12.99 €',
            'host_url'=>'http://subyshare.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'ulozto.net',
            'logo' => 'ulozto.png',
            'logo_monochrome' => 'ulozto_mono.png',
            'logo_small' => 'ulozto_small.png',
            'logo_large' => 'ulozto_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'40 EUR',
            'host_url'=>'https://ulozto.net/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'salefiles.com',
            'logo' => 'salefiles.png',
            'logo_monochrome' => 'salefiles_mono.png',
            'logo_small' => 'salefiles_small.png',
            'logo_large' => 'salefiles_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'11.99 $',
            'host_url'=>'http://salefiles.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'sendspace.com',
            'logo' => 'sendspace.png',
            'logo_monochrome' => 'sendspace_mono.png',
            'logo_small' => 'sendspace_small.png',
            'logo_large' => 'sendspace_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'8.99 $/Month',
            'host_url'=>'https://www.sendspace.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'speedyshare.com',
            'logo' => 'speedyshare.png',
            'logo_monochrome' => 'speedyshare_mono.png',
            'logo_small' => 'speedyshare_small.png',
            'logo_large' => 'speedyshare_large.png',
            'max_mb_per_day'=>'0',
            'download_options'=>'1 website',
            'pricing'=>'0',
            'host_url'=>'http://speedyshare.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'rockfile.eu',
            'logo' => 'rockfile.png',
            'logo_monochrome' => 'rockfile_mono.png',
            'logo_small' => 'rockfile_small.png',
            'logo_large' => 'rockfile_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'17.99 $',
            'host_url'=>'http://rockfile.eu/'
        ]);

           $this->insert('{{%hosts}}', [
            'name' => 'zippyshare.com',
            'logo' => 'zippyshare.png',
            'logo_monochrome' => 'zippyshare_mono.png',
            'logo_small' => 'zippyshare_small.png',
            'logo_large' => 'zippyshare_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'free',
            'host_url'=>'http://www.zippyshare.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'bigfile.to',
            'logo' => 'bigfile.png',
            'logo_monochrome' => 'bigfile_mono.png',
            'logo_small' => 'bigfile_small.png',
            'logo_large' => 'bigfile_large.png',
            'max_mb_per_day'=>'0.43 per day',
            'download_options'=>'1 website',
            'pricing'=>'12.99 $',
            'host_url'=>'https://www.bigfile.to/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'uptobox.com',
            'logo' => 'uptobox.png',
            'logo_monochrome' => 'uptobox_mono.png',
            'logo_small' => 'uptobox_small.png',
            'logo_large' => 'uptobox_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'3,00€',
            'host_url'=>'http://uptobox.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'filefactory.com',
            'logo' => 'filefactory.png',
            'logo_monochrome' => 'filefactory_mono.png',
            'logo_small' => 'filefactory_small.png',
            'logo_large' => 'filefactory_large.png',
            'max_mb_per_day'=>'5 GB',
            'download_options'=>'1 website',
            'pricing'=>'13 $',
            'host_url'=>'http://filefactory.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'depositfiles.com',
            'logo' => 'depositfiles.png',
            'logo_monochrome' => 'depositfiles_mono.png',
            'logo_small' => 'fdepositfiles_small.png',
            'logo_large' => 'depositfiles_large.png',
            'max_mb_per_day'=>' 0.39 $ per day',
            'download_options'=>'1 website',
            'pricing'=>'11.95 USD',
            'host_url'=>'http://dfiles.ru/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'uplea.com',
            'logo' => 'uplea.png',
            'logo_monochrome' => 'uplea_mono.png',
            'logo_small' => 'uplea_small.png',
            'logo_large' => 'uplea_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'1.99 €',
            'host_url'=>'http://uplea.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'fboom.me',
            'logo' => 'fboom.png',
            'logo_monochrome' => 'fboom_mono.png',
            'logo_small' => 'fboom_small.png',
            'logo_large' => 'fboom_large.png',
            'max_mb_per_day'=>'5 GB',
            'download_options'=>'1 website',
            'pricing'=>'4.95 $',
            'host_url'=>'http://fboom.me/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'www.rarefile.net',
            'logo' => 'rarefile.png',
            'logo_monochrome' => 'rarefile_mono.png',
            'logo_small' => 'rarefile_small.png',
            'logo_large' => 'rarefile_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'$ 12.90',
            'host_url'=>'http://www.rarefile.net/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'interfile.net',
            'logo' => 'interfile.png',
            'logo_monochrome' => 'interfile_mono.png',
            'logo_small' => 'finterfile_small.png',
            'logo_large' => 'interfile_large.png',
            'max_mb_per_day'=>'0',
            'download_options'=>'1 website',
            'pricing'=>'0',
            'host_url'=>'http://interfile.net/?op=login'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'limefile.com',
            'logo' => 'limefile.png',
            'logo_monochrome' => 'limefile_mono.png',
            'logo_small' => 'limefile_small.png',
            'logo_large' => 'limefile_large.png',
            'max_mb_per_day'=>'Unlimited',
            'download_options'=>'1 website',
            'pricing'=>'12.99 $',
            'host_url'=>'http://limefile.com/'
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'filespace.com',
            'logo' => 'filespace.png',
            'logo_monochrome' => 'filespace_mono.png',
            'logo_small' => 'filespace_small.png',
            'logo_large' => 'filespace_large.png',
            'max_mb_per_day'=>'500 GB',
            'download_options'=>'1 website',
            'pricing'=>'13.71 $',
            'host_url'=>'http://filespace.com/'
        ]);

        $queries_hosts = (new Query())->select('name')->from('hosts');
        $queries_content_providers = (new Query())->select('name,id')->from('content_providers');
        foreach ($queries_content_providers->each() as $query) {
            \Yii::$app->db->createCommand('UPDATE hosts SET `content_provider_id` = '.$query['id'].' WHERE name = "'.$query["name"].'"')->execute();
        }
    }

    public function down()
    {
        echo "m161201_093826_remove_hosts_duplicates cannot be reverted.\n";

        return false;
    }

}
