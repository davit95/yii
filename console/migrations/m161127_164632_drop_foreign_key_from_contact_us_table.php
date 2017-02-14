<?php

use yii\db\Migration;

/**
 * Handles the dropping for table `foreign_key_from_contact_us`.
 */
class m161127_164632_drop_foreign_key_from_contact_us_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropForeignKey('fk_contact_us_messages_sender_id', "{{%contact_us_messages}}");
        \Yii::$app->db->createCommand('ALTER TABLE  `contact_us_messages` MODIFY COLUMN  `sender_id` integer')->execute();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addForeignKey('fk_contact_us_messages_sender_id', '{{%contact_us_messages}}', 'sender_id', '{{%users}}', 'id', 'CASCADE', 'NO ACTION');
        \Yii::$app->db->createCommand('ALTER TABLE  `contact_us_messages` MODIFY COLUMN  `sender_id` integer NOT NULL')->execute();
    }
}
