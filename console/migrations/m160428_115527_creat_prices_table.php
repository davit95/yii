<?php

use yii\db\Migration;

class m160428_115527_creat_prices_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%prices}}', [
            'id' => $this->primaryKey(),
            'amount' => $this->double(),
            'product_type' => $this->string(),
            'period'  => $this->string(),
            'limit' => $this->double(),
            'currency' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ],'ENGINE=InnoDB');

        $timmestamp = time();

         $this->insert('{{%prices}}', [
            'amount' => '12.99',
            'product_type' =>'daily',
            'period' => 30,
            'limit' =>'unlimited',
            'currency' => 'USD',
            //'description' => "PLG 30 day product,unlimited",
            'created_at' => $timmestamp,
            'updated_at' => $timmestamp,
        ]);
        $this->insert('{{%prices}}', [
            'amount' => '29.99',
            'product_type' =>'daily',
            'period' => 90,
            'limit' =>'unlimited',
            'currency' => 'USD',
            //'description' => "PLG 90 day product,unlimited",
            'created_at' => $timmestamp,
            'updated_at' => $timmestamp,
        ]);
        $this->insert('{{%prices}}', [
            'amount' => '49.99',
            'product_type' =>'daily',
            'period' => 180,
            'limit' =>'unlimited',
            'currency' => 'USD',
            //'description' => "PLG 180 day product,unlimited",
            'created_at' => $timmestamp,
            'updated_at' => $timmestamp,
        ]);
        $this->insert('{{%prices}}', [
            'amount' => '89.99',
            'product_type' =>'daily',
            'period' => 365,
            'limit' =>'unlimited',
            'currency' => 'USD',
            //'description' => "PLG 365 day product,unlimited",
            'created_at' => $timmestamp,
            'updated_at' => $timmestamp,
        ]);
        $this->insert('{{%prices}}', [
            'amount' => '149.99',
            'product_type' =>'daily',
            'period' => 730,
            'limit' =>'unlimited',
            'currency' => 'USD',
            //'description' => "PLG 730 day product,unlimited",
            'created_at' => $timmestamp,
            'updated_at' => $timmestamp,
        ]);

        $this->insert('{{%prices}}', [
            'amount' => '12.99',
            'product_type' =>'limited',
            'period' => 0,
            'limit' =>50,
            'currency' => 'USD',
            //'description' => "PLG 50Gb product,unlimited",
            'created_at' => $timmestamp,
            'updated_at' => $timmestamp,
        ]);
          $this->insert('{{%prices}}', [
            'amount' => '29.99',
            'product_type' =>'limited',
            'period' => 0,
            'limit' => 150,
            'currency' => 'USD',
            //'description' => "PLG 150Gb product,unlimited",
            'created_at' => $timmestamp,
            'updated_at' => $timmestamp,
        ]);
           $this->insert('{{%prices}}', [
            'amount' => '49.99',
            'product_type' =>'limited',
            'period' => 0,
            'limit' => 300,
            'currency' => 'USD',
            //'description' => "PLG 300Gb product,unlimited",
            'created_at' => $timmestamp,
            'updated_at' => $timmestamp,
        ]);
            $this->insert('{{%prices}}', [
            'amount' => '89.99',
            'product_type' =>'limited',
            'period' => 0,
            'limit' => 600,
            'currency' => 'USD',
            //'description' => "PLG 600Gb product,unlimited",
            'created_at' => $timmestamp,
            'updated_at' => $timmestamp,
        ]);
             $this->insert('{{%prices}}', [
            'amount' => '149.99',
            'product_type' =>'limited',
            'period' => 0,
            'limit' => 5000,
            'currency' => 'USD',
            //'description' => "PLG 5000Gb product,unlimited",
            'created_at' => $timmestamp,
            'updated_at' => $timmestamp,
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%prices}}');
    }

}
