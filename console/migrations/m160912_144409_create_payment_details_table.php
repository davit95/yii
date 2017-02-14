<?php

use yii\db\Migration;

/**
 * Handles the creation for table `payment_details`.
 */
class m160912_144409_create_payment_details_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('payment_details', [
            'id' => $this->primaryKey(),
            'last_name' => $this->string(),
            'first_name' => $this->string(),
            'pm_id'=>$this->string(),
            'user_id'  => $this->integer(),
            'email'  => $this->string(),
            'plan_id' => $this->integer(),
            'plan_key' => $this->integer(),
            'order_id' => $this->integer(),
            'target_niche' => $this->string(),
            'target_country' => $this->string(),
            'callback_url'=> $this->string(),
            'start_date'=> $this->integer()->notNull(),
            'period'=>$this->string(),
            'limit'=>$this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ],'ENGINE=InnoDB');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('payment_details');
    }
}
