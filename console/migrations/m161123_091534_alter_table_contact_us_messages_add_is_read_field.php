<?php

use yii\db\Migration;

class m161123_091534_alter_table_contact_us_messages_add_is_read_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%contact_us_messages}}', 'is_read',$this->boolean()->notNull()->defaultValue(0));
        $this->addColumn('{{%contact_us_messages}}', 'mark_as_important',$this->boolean()->notNull()->defaultValue(0));
    }

    public function down()
    {
        echo "m161123_091534_alter_table_contact_us_messages_add_is_read_field cannot be reverted.\n";

        return false;
    }

}
