<?php

use yii\db\Migration;

class m161121_120024_populate_products_and_prices extends Migration
{
    public function up()
    {
        $this->insert('{{%products}}', [
            'id' => '1',
            'name' => 'PLG 30 days',
            'description' => 'PLG 30 days product, unlimited',
            'type' => 'DAILY',
            'limit' => null,
            'days' => 30,
            'status' => 'ACTIVE',
            'created' => time(),
            'updated' => time()
        ]);
        $this->insert('{{%products}}', [
            'id' => '2',
            'name' => 'PLG 90 days',
            'description' => 'PLG 90 days product, unlimited',
            'type' => 'DAILY',
            'limit' => null,
            'days' => 90,
            'status' => 'ACTIVE',
            'created' => time(),
            'updated' => time()
        ]);
        $this->insert('{{%products}}', [
            'id' => 3,
            'name' => 'PLG 180 days',
            'description' => 'PLG 180 days product, unlimited',
            'type' => 'DAILY',
            'limit' => null,
            'days' => 180,
            'status' => 'ACTIVE',
            'created' => time(),
            'updated' => time()
        ]);
        $this->insert('{{%products}}', [
            'id' => 4,
            'name' => 'PLG 365 days',
            'description' => 'PLG 365 days product, unlimited',
            'type' => 'DAILY',
            'limit' => null,
            'days' => 365,
            'status' => 'ACTIVE',
            'created' => time(),
            'updated' => time()
        ]);
        $this->insert('{{%products}}', [
            'id' => 5,
            'name' => 'PLG 730 days',
            'description' => 'PLG 730 days product, unlimited',
            'type' => 'DAILY',
            'limit' => null,
            'days' => 730,
            'status' => 'ACTIVE',
            'created' => time(),
            'updated' => time()
        ]);

        $this->insert('{{%products}}', [
            'id' => 6,
            'name' => 'PLG 50 Gb',
            'description' => 'PLG 50 Gb product, unlimited',
            'type' => 'LIMITED',
            'limit' => 50,
            'days' => null,
            'status' => 'ACTIVE',
            'created' => time(),
            'updated' => time()
        ]);
        $this->insert('{{%products}}', [
            'id' => 7,
            'name' => 'PLG 150 Gb',
            'description' => 'PLG 150 Gb product, unlimited',
            'type' => 'LIMITED',
            'limit' => 150,
            'days' => null,
            'status' => 'ACTIVE',
            'created' => time(),
            'updated' => time()
        ]);
        $this->insert('{{%products}}', [
            'id' => 8,
            'name' => 'PLG 300 Gb',
            'description' => 'PLG 300 Gb product, unlimited',
            'type' => 'LIMITED',
            'limit' => 300,
            'days' => null,
            'status' => 'ACTIVE',
            'created' => time(),
            'updated' => time()
        ]);
        $this->insert('{{%products}}', [
            'id' => 9,
            'name' => 'PLG 600 Gb',
            'description' => 'PLG 600 Gb product, unlimited',
            'type' => 'LIMITED',
            'limit' => 600,
            'days' => null,
            'status' => 'ACTIVE',
            'created' => time(),
            'updated' => time()
        ]);
        $this->insert('{{%products}}', [
            'id' => 10,
            'name' => 'PLG 5000 Gb',
            'description' => 'PLG 5000 Gb product, unlimited',
            'type' => 'LIMITED',
            'limit' => 5000,
            'days' => null,
            'status' => 'ACTIVE',
            'created' => time(),
            'updated' => time()
        ]);
    }

    public function down()
    {
        echo "m161121_120024_populate_products_and_prices cannot be reverted.\n";

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
