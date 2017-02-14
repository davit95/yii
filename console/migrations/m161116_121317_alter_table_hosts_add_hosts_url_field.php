<?php

use yii\db\Migration;
use yii\db\Query;

class m161116_121317_alter_table_hosts_add_hosts_url_field extends Migration
{
    public function up()
    {
        $host_urls = $this->addColumn('{{%hosts}}', 'host_url', $this->string().' AFTER `name`');

        $host_urls = [
            ['name'=>'1fichier.com','host_url'=>'https://1fichier.com/'],
            ['name'=>'alfafile.net','host_url'=>'http://alfafile.net/'],
            ['name'=>'depfile.com','host_url'=>'http://depfile.com/'],
            ['name'=>'filesflash.com','host_url'=>'http://filesflash.com/'],
            ['name'=>'junocloud.me','host_url'=>'http://junocloud.me/'],
            ['name'=>'hugefiles.net','host_url'=>'http://hugefiles.net'],
            ['name'=>'filesflash.com','host_url'=>'http://filesflash.com/'],
            ['name'=>'fileload.io','host_url'=>'https://fileload.io/'],
            ['name'=>'nosvideo.com','host_url'=>'http://nosvideo.com/'],
            ['name'=>'novafile.com','host_url'=>'http://novafile.com/'],
            ['name'=>'share-online.biz','host_url'=>'http://www.share-online.biz/'],
            ['name'=>'lafiles.com','host_url'=>'http://lafiles.com/?op=login'],
            ['name'=>'usercloud.com','host_url'=>'http://usercloud.com/'],
            ['name'=>'foxupload.online','host_url'=>'https://foxupload.online/'],
            ['name'=>'mediafire.com','host_url'=>'https://www.mediafire.com/'],
            ['name'=>'nitroflare.com','host_url'=>'http://nitroflare.com/'],
            ['name'=>'cloudsix.me','host_url'=>'http://cloudsix.me/'],
            ['name'=>'upasias.com','host_url'=>'http://upasias.com/?op=login'],
            ['name'=>'solidfiles.com','host_url'=>'https://www.solidfiles.com/'],
            ['name'=>'upstore.net','host_url'=>'https://upstore.net/'],
            ['name'=>'rapidfileshare.net','host_url'=>'http://www.rapidfileshare.net/'],
            ['name'=>'florenfile.com','host_url'=>'http://florenfile.com/'],
            ['name'=>'depfile.com','host_url'=>'http://depfile.com/'],
            ['name'=>'daofile.com','host_url'=>'http://daofile.com/'],
            ['name'=>'redbunker.net','host_url'=>'http://redbunker.net/'],
            ['name'=>'mediafree.co','host_url'=>'http://mediafree.co/'],
            ['name'=>'secureupload.eu','host_url'=>'https://secureupload.eu/login'],
            ['name'=>'bitvid.sx','host_url'=>'http://www.bitvid.sx/'],
            ['name'=>'rapidgator.net','host_url'=>'http://rapidgator.net/'],
            ['name'=>'hitfile.net','host_url'=>'http://hitfile.net/'],
            ['name'=>'anafile.com','host_url'=>'http://anafile.com/'],
            ['name'=>'megacache.net','host_url'=>'http://megacache.net'],
            ['name'=>'gboxes.com','host_url'=>'http://www.gboxes.com/'],
            ['name'=>'2shared.com','host_url'=>'http://www.2shared.com/'],
            ['name'=>'clicknupload.link','host_url'=>'https://clicknupload.link/'],
            ['name'=>'openload.co','host_url'=>'https://openload.co/'],
            ['name'=>'kingfiles.net','host_url'=>'http://kingfiles.net/'],
            ['name'=>'tusfiles.net','host_url'=>'https://tusfiles.net/'],
            ['name'=>'filejoker.net','host_url'=>'https://filejoker.net/'],
            ['name'=>'alfafile.net','host_url'=>'http://alfafile.net/'],
            ['name'=>'turbobit.net','host_url'=>'http://turbobit.net/'],
            ['name'=>'upload.cd','host_url'=>'http://upload.cd/'],
            ['name'=>'wipfiles.net','host_url'=>'http://wipfiles.net/'],
            ['name'=>'keep2share.cc','host_url'=>'http://keep2share.cc/'],
            ['name'=>'datafile.com','host_url'=>'http://www.datafile.com/'],
            ['name'=>'doraupload.com','host_url'=>'http://doraupload.com/'],
            ['name'=>'subyshare.com','host_url'=>'http://subyshare.com/'],
            ['name'=>'ulozto.net','host_url'=>'https://ulozto.net/'],
            ['name'=>'salefiles.com','host_url'=>'http://salefiles.com/'],
            ['name'=>'sendspace.com','host_url'=>'https://www.sendspace.com/'],
            ['name'=>'speedyshare.com','host_url'=>'http://speedyshare.com/'],
            ['name'=>'rockfile.eu','host_url'=>'http://rockfile.eu/'],
            ['name'=>'zippyshare.com','host_url'=>'http://www.zippyshare.com/'],
            ['name'=>'bigfile.to','host_url'=>'https://www.bigfile.to/'],
            ['name'=>'uptobox.com','host_url'=>'http://uptobox.com/'],
            ['name'=>'filefactory.com','host_url'=>'http://filefactory.com/'],
            ['name'=>'depositfiles.com','host_url'=>'http://dfiles.ru/'],
            ['name'=>'uplea.com','host_url'=>'http://uplea.com/'],
            ['name'=>'fboom.me','host_url'=>'http://fboom.me/'],
            ['name'=>'www.rarefile.net','host_url'=>'http://www.rarefile.net/'],
            ['name'=>'interfile.net','host_url'=>'http://interfile.net/?op=login'],
            ['name'=>'limefile.com','host_url'=>'http://limefile.com/'],
            ['name'=>'filespace.com','host_url'=>'http://filespace.com/'],
            ['name'=>'megacache.net','host_url'=>'http://megacache.net'],
        ];

        foreach ($host_urls as $item) {
            \Yii::$app->db->createCommand("UPDATE hosts SET host_url=:hosts_url WHERE name=:name ")
            ->bindValue(':hosts_url', $item['host_url'])
            ->bindValue(':name',$item['name'])
            ->execute();
        }
    }

    public function down()
    {
        echo "m161116_121317_alter_table_hosts_add_hosts_url_field cannot be reverted.\n";

        return false;
    }
}
