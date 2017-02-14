<?php

use yii\db\Migration;
use yii\db\Query;

class m160419_133533_create_credentials_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%credentials}}', [
            'id' => $this->primaryKey(),
            'user' => $this->string(500)->notNull(),
            'pass' => $this->string(500)->notNull(),
            'status' => 'ENUM("ACTIVE","INACTIVE") NOT NULL'
        ]);

        $this->createTable('{{%content_providers_credentials}}', [
            'content_provider_id' => $this->integer(11)->notNull(),
            'credential_id' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey('fk_content_providers_credentials_content_provider_id','{{%content_providers_credentials}}','content_provider_id','{{%content_providers}}','id','CASCADE','NO ACTION');
        $this->addForeignKey('fk_content_providers_credentials_credential_id','{{%content_providers_credentials}}','credential_id','{{%credentials}}','id','CASCADE','NO ACTION');

        $key = 'iET1IM1GYh';

        $this->insert('{{%credentials}}', [
            'user' => utf8_encode(Yii::$app->security->encryptByKey('jaap.schoon@aol.com', $key)),
            'pass' => utf8_encode(Yii::$app->security->encryptByKey('e7R6h1h&yU7QYPU', $key)),
            'status' => 'ACTIVE'
        ]);
        $cId = $this->db->getLastInsertId();

        $query = new Query();

        $query->select('id');
        $query->from('{{%content_providers}}');
        $query->where(['name' => '1fichier.com']);
        $cpId = $query->scalar();

        $this->insert('{{%content_providers_credentials}}', [
            'content_provider_id' => $cpId,
            'credential_id' => $cId
        ]);
    }

    public function down()
    {
        return false;
    }
}
