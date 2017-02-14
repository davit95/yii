<?php

use yii\db\Migration;

class m161126_083912_alter_table_contact_us_messages_add_parent_id extends Migration
{
    public function up()
    {
        $this->addColumn('{{%contact_us_messages}}', 'parent_id',$this->integer()." AFTER id");
        $this->addForeignKey('fk_contact_us_messages_parent_id', '{{%contact_us_messages}}', 'parent_id', '{{%contact_us_messages}}', 'id', 'CASCADE', 'NO ACTION');
    }

    public function down()
    {
        $this->dropForeignKey('fk_contact_us_messages_parent_id', "{{%contact_us_messages}}");
        $this->dropColumn('{{%contact_us_messages}}', 'parent_id');
    }

}
