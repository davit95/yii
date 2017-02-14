<?php

use yii\db\Migration;
use yii\db\Query;

class m160915_102724_update_prices_table_set_descritpion_add_product_name_field extends Migration
{
    public function up()
    {
        $product_name = $this->addColumn('{{%prices}}', 'product_name', $this->string());

        $descriptions = [
            1 => "PLG 30 day product,unlimited",
            2 => "PLG 90 day product,unlimited",
            3 => "PLG 180 day product,unlimited",
            4 => "PLG 365 day product,unlimited",
            5 => "PLG 730 day product,unlimited",
            6 => "PLG 50 Gb product,unlimited",
            7 => "PLG 150 Gb product,unlimited",
            8 => "PLG 300 Gb product,unlimited",
            9 => "PLG 600 Gb product,unlimited",
            10 => "PLG 5000 Gb product,unlimited",
        ];

        $product_names = [
            1 => "PLG 30 day",
            2 => "PLG 90 day",
            3 => "PLG 180 day",
            4 => "PLG 365 day",
            5 => "PLG 730 day",
            6 => "PLG 50 Gb",
            7 => "PLG 150 Gb",
            8 => "PLG 300 Gb",
            9 => "PLG 600 Gb",
            10 => "PLG 5000 Gb",
        ];

        $queries = (new Query())->select('id')->from('prices');
        foreach ($queries->each() as $id => $value) {
            \Yii::$app->db->createCommand("UPDATE `prices` SET `product_name`= '".$product_names[$id]."' ,`description`= '".$descriptions[$id]."'")->execute();
        }
    }

    public function down()
    {
        $this->dropColumn('{{%prices}}', 'product_name');
    }

}
