<?php

use yii\db\Migration;

class m160405_063401_create_hosts_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%hosts}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'logo' => $this->string(50)->notNull(),
            'logo_monochrome' => $this->string(50)->notNull(),
            'logo_small' => $this->string(50)->notNull(),
            'logo_large' => $this->string(50)->notNull(),
        ], $tableOptions);

        //Add sample data
        $this->insert('{{%hosts}}', [
            'name' => '1fichier.com',
            'logo' => '1fichier.png',
            'logo_monochrome' => '1fichier_mono.png',
            'logo_small' => '1fichier_small.png',
            'logo_large' => '1fichier_large.png',
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'alfafile.net',
            'logo' => 'alfafile.png',
            'logo_monochrome' => 'alfafile_mono.png',
            'logo_small' => 'alfafile_small.png',
            'logo_large' => 'alfafile_large.png',
        ]);

        $this->insert('{{%hosts}}', [
            'name' => 'depfile.com',
            'logo' => 'depfile.png',
            'logo_monochrome' => 'depfile_mono.png',
            'logo_small' => 'depfile_small.png',
            'logo_large' => 'depfile_large.png',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%hosts}}');
    }
}
