<?php

use yii\db\Migration;
use yii\db\Query;

class m160916_080134_update_statistical_indexes_attributes extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%statistical_indexes}}', 'attributes', $this->string(1024)->notNull());

        $query = new Query();
        $query->select(['id', 'name', 'attributes']);
        $query->from('{{%statistical_indexes}}');

        foreach ($query->each() as $index) {
            $attrs = @unserialize($index['attributes']);

            if ($attrs != false) {
                if ($index['name'] == 'sended_content_attrs') {
                    $attrs[] = [
                        'name' => 'timestamp'
                    ];
                } else {
                    $attrs[] = [
                        'name' => 'timestamp',
                        'aggr' => 'MIN',
                        'alias' => 'from'
                    ];
                    $attrs[] = [
                        'name' => 'timestamp',
                        'aggr' => 'MAX',
                        'alias' => 'to'
                    ];
                }
            }

            $this->update('{{%statistical_indexes}}', ['attributes' => serialize($attrs)], ['id' => $index['id']]);
        }
    }

    public function down()
    {
        echo "m160916_080134_update_statistical_indexes_attributes cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
