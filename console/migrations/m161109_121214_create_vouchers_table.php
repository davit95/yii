<?php

use yii\db\Migration;

/**
 * Handles the creation for table `vouchers`.
 */
class m161109_121214_create_vouchers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%vouchers}}', [
            'id' => $this->primaryKey(),
            'voucher' => $this->string(40)->notNull(),
            'product_id' => $this->integer(11)->notNull(),
            'issuer_id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->defaultValue(null),
            'created' => $this->integer(11)->notNull(),
            'used' => $this->integer(11)->notNull(),
            'status' => 'ENUM("NOT USED", "USED", "SUSPENDED")'
        ]);

        $this->addForeignKey('fk_vouchers_product_id', '{{%vouchers}}', 'product_id', '{{%prices}}', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey('fk_vouchers_issuer_id', '{{%vouchers}}', 'issuer_id', '{{%users}}', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey('fk_vouchers_user_id', '{{%vouchers}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('vouchers');
    }
}
