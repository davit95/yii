<?php

use yii\db\Migration;

class m161201_094937_udate_contact_us_page_content extends Migration
{
    public function up()
    {
        $this->insert('{{%source_message}}', [
            'category' => 'contact_us',
            'message' => 'Address'
        ]);

        $id = Yii::$app->db->getLastInsertID();

        $this->insert('{{%message}}', [
            'id' => $id,
            'language' => 'en',
            'translation' => 'Address'
        ]);
        $this->insert('{{%message}}', [
            'id' => $id,
            'language' => 'ru',
            'translation' => 'Адрес'
        ]);
    }

    public function down()
    {
        echo "m161201_094937_udate_contact_us_page_content cannot be reverted.\n";

        return false;
    }
}
