<?php

use yii\db\Migration;

class m161122_142755_alter_products_table_add_price_and_currency_cols extends Migration
{
    public function up()
    {
        $this->addColumn('{{%products}}', 'price', $this->decimal(12, 2)->notNull().' AFTER `days`');
        $this->addColumn('{{%products}}', 'price_currency', $this->string(3)->notNull().' AFTER `price`');

        $this->update('{{%products}}', ['price' => 12.99, 'price_currency' => 'USD'], ['name' => 'PLG 30 days']);
        $this->update('{{%products}}', ['price' => 12.99, 'price_currency' => 'USD'], ['name' => 'PLG 50 Gb']);

        $this->update('{{%products}}', ['price' => 29.99, 'price_currency' => 'USD'], ['name' => 'PLG 90 days']);
        $this->update('{{%products}}', ['price' => 29.99, 'price_currency' => 'USD'], ['name' => 'PLG 150 Gb']);

        $this->update('{{%products}}', ['price' => 49.99, 'price_currency' => 'USD'], ['name' => 'PLG 180 days']);
        $this->update('{{%products}}', ['price' => 49.99, 'price_currency' => 'USD'], ['name' => 'PLG 300 Gb']);

        $this->update('{{%products}}', ['price' => 89.99, 'price_currency' => 'USD'], ['name' => 'PLG 365 days']);
        $this->update('{{%products}}', ['price' => 89.99, 'price_currency' => 'USD'], ['name' => 'PLG 600 Gb']);

        $this->update('{{%products}}', ['price' => 149.99, 'price_currency' => 'USD'], ['name' => 'PLG 730 days']);
        $this->update('{{%products}}', ['price' => 149.99, 'price_currency' => 'USD'], ['name' => 'PLG 5000 Gb']);
    }

    public function down()
    {
        echo "m161122_142755_alter_products_table_add_price_and_currency_cols cannot be reverted.\n";

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
