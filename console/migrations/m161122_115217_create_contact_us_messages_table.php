<?php

use yii\db\Migration;

/**
 * Handles the creation for table `contact_us_messages`.
 */
class m161122_115217_create_contact_us_messages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%contact_us_messages}}', [
            'id' => $this->primaryKey(),
            'receiver_id' => $this->integer(11)->notNull(),
            'sender_id' => $this->integer(11)->notNull(),
            'email' => $this->string()->notNull(),
            'subject' => $this->string(),
            'message' => $this->text()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey('fk_contact_us_messages_sender_id', '{{%contact_us_messages}}', 'sender_id', '{{%users}}', 'id', 'CASCADE', 'NO ACTION');

        $this->addForeignKey('fk_contact_us_messages_receiver_id', '{{%contact_us_messages}}', 'receiver_id', '{{%users}}', 'id', 'CASCADE', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_contact_us_messages_sender_id', "{{%contact_us_messages}}");
        $this->dropForeignKey('fk_contact_us_messages_receiver_id', "{{%contact_us_messages}}");
        $this->dropTable('{{%contact_us_messages}}');
    }
}
