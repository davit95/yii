<?php

use yii\db\Migration;

class m161129_112756_alter_table_hosts_add_host_information extends Migration
{
    public function up()
    {
        $this->addColumn('{{%hosts}}', 'max_mb_per_day', $this->string().' AFTER `limit`');
        $this->addColumn('{{%hosts}}', 'download_options', $this->string().' AFTER `max_mb_per_day`');
        $this->addColumn('{{%hosts}}', 'pricing', $this->string().' AFTER `download_options`');

        $host_data = [
            ['name'=>'1fichier.com','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'1 €'],
            ['name'=>'alfafile.net','max_mb_per_day'=>'50 gb','download_options'=>'1 website','pricing'=>'14.99 $'],
            ['name'=>'depfile.com','max_mb_per_day'=>'download_options','download_options'=>'1 website','pricing'=>'19.95 $'],
            ['name'=>'filesflash.com','max_mb_per_day'=>'10 GB','download_options'=>'1 website','pricing'=>'12 $'],
            ['name'=>'junocloud.me','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'8.89 €'],
            ['name'=>'hugefiles.net','max_mb_per_day'=>'0','download_options'=>'1 website','pricing'=>'0'],
            ['name'=>'filesflash.com','max_mb_per_day'=>'10 GB','download_options'=>'1 website','pricing'=>'12 $'],
            ['name'=>'fileload.io','max_mb_per_day'=>'25 GB','download_options'=>'1 website','pricing'=>'4,99 €'],
            ['name'=>'nosvideo.com','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'No Price'],
            ['name'=>'novafile.com','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'9.95 $ + Tax 21%'],
            ['name'=>'share-online.biz','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'9.49 €'],
            ['name'=>'lafiles.com','max_mb_per_day'=>'20 GB in 3 days','download_options'=>'1 website','pricing'=>'$13.99'],
            ['name'=>'usercloud.com','max_mb_per_day'=>'0','download_options'=>'1 website','pricing'=>'0'],
            ['name'=>'foxupload.online','max_mb_per_day'=>'0','download_options'=>'1 website','pricing'=>'0'],
            ['name'=>'mediafire.com','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'50.00 $ / month'],
            ['name'=>'nitroflare.com','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'12.00 $'],
            ['name'=>'cloudsix.me','max_mb_per_day'=>'unlimited','download_options'=>'1 website','pricing'=>'$19.95'],
            ['name'=>'upasias.com','max_mb_per_day'=>'24 GB in 3 days','download_options'=>'1 website','pricing'=>'12.99 $'],
            ['name'=>'solidfiles.com','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'9.99 €'],
            ['name'=>'upstore.net','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'11.95€'],
            ['name'=>'rapidfileshare.net','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'10 $'],
            ['name'=>'florenfile.com','max_mb_per_day'=>'20 GB in 3 days','download_options'=>'1 website','pricing'=>'9.95 $'],
            ['name'=>'depfile.com','max_mb_per_day'=>'download_options','download_options'=>'1 website','pricing'=>'19.95 $'],
            ['name'=>'daofile.com','max_mb_per_day'=>'0','download_options'=>'1 website','pricing'=>'0'],
            ['name'=>'redbunker.net','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'14.99 $'],
            ['name'=>'mediafree.co','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'5.00 $'],
            ['name'=>'secureupload.eu','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'12.99 USD'],
            ['name'=>'bitvid.sx','max_mb_per_day'=>'3 cents per day','download_options'=>'1 website','pricing'=>'10 $'],
            ['name'=>'rapidgator.net','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'14.99 $'],
            ['name'=>'hitfile.net','max_mb_per_day'=>'unlimited','download_options'=>'1 website','pricing'=>'9.95 $'],
            ['name'=>'anafile.com','max_mb_per_day'=>'unlimited','download_options'=>'1 website','pricing'=>'5.00 $'],
            ['name'=>'megacache.net','max_mb_per_day'=>'0','download_options'=>'1 website','pricing'=>'0'],
            ['name'=>'gboxes.com','max_mb_per_day'=>'0','download_options'=>'1 website','pricing'=>'0'],
            ['name'=>'2shared.com','max_mb_per_day'=>'200 mb','download_options'=>'1 website','pricing'=>'free'],
            ['name'=>'clicknupload.link','max_mb_per_day'=>'0','download_options'=>'1 website','pricing'=>'0'],
            ['name'=>'openload.co','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'free'],
            ['name'=>'kingfiles.net','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'3.00 $'],
            ['name'=>'tusfiles.net','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'9.99 €'],
            ['name'=>'filejoker.net','max_mb_per_day'=>'unlimited','download_options'=>'1 website','pricing'=>'9.95 $'],
            ['name'=>'alfafile.net','max_mb_per_day'=>'','download_options'=>'1 website','pricing'=>''],
            ['name'=>'turbobit.net','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'9.95 €'],
            ['name'=>'upload.cd','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'$15.99'],
            ['name'=>'wipfiles.net','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'$12.95'],
            ['name'=>'keep2share.cc','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'4.95 $'],
            ['name'=>'datafile.com','max_mb_per_day'=>'0.5 $ per day','download_options'=>'1 website','pricing'=>'14.99 $'],
            ['name'=>'doraupload.com','max_mb_per_day'=>'unlimited','download_options'=>'1 website','pricing'=>'10.85 $'],
            ['name'=>'subyshare.com','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'12.99 €'],
            ['name'=>'ulozto.net','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'40 EUR'],
            ['name'=>'salefiles.com','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'11.99 $'],
            ['name'=>'sendspace.com','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'8.99 $/Month'],
            ['name'=>'speedyshare.com','max_mb_per_day'=>'0','download_options'=>'1 website','pricing'=>'0'],
            ['name'=>'rockfile.eu','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'17.99 $'],
            ['name'=>'zippyshare.com','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'free'],
            ['name'=>'bigfile.to','max_mb_per_day'=>'0.43 per day','download_options'=>'1 website','pricing'=>'12.99 $'],
            ['name'=>'uptobox.com','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'3,00€'],
            ['name'=>'filefactory.com','max_mb_per_day'=>'5 GB','download_options'=>'1 website','pricing'=>'13 $'],
            ['name'=>'depositfiles.com','max_mb_per_day'=>' 0.39 $ per day','download_options'=>'1 website','pricing'=>'11.95 USD'],
            ['name'=>'uplea.com','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'1.99 €'],
            ['name'=>'fboom.me','max_mb_per_day'=>'5 GB','download_options'=>'1 website','pricing'=>'4.95 $'],
            ['name'=>'www.rarefile.net','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'$ 12.90'],
            ['name'=>'interfile.net','max_mb_per_day'=>'0','download_options'=>'1 website','pricing'=>'0'],
            ['name'=>'limefile.com','max_mb_per_day'=>'Unlimited','download_options'=>'1 website','pricing'=>'12.99 $'],
            ['name'=>'filespace.com','max_mb_per_day'=>'500 GB','download_options'=>'1 website','pricing'=>'13.71 $'],
            ['name'=>'megacache.net','max_mb_per_day'=>'0','download_options'=>'1 website','pricing'=>'0'],
        ];

        foreach ($host_data as $item) {
            \Yii::$app->db->createCommand("UPDATE hosts SET max_mb_per_day=:max_mb_per_day,download_options=:download_options,pricing=:pricing WHERE name=:name ")
            ->bindValue(':max_mb_per_day', $item['max_mb_per_day'])
            ->bindValue(':download_options', $item['download_options'])
            ->bindValue(':pricing', $item['pricing'])
            ->bindValue(':name',$item['name'])
            ->execute();
        }

        \Yii::$app->db->createCommand("UPDATE hosts SET host_url=:host_url WHERE name=:name ")
            ->bindValue(':host_url','http://dfiles.eu/')
            ->bindValue(':name', 'depositfiles.com')
            ->execute();
    }

    public function down()
    {
        echo "m161129_112756_alter_table_hosts_add_host_information cannot be reverted.\n";

        return false;
    }
}
