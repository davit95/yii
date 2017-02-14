<?php

use yii\db\Migration;
use yii\db\Query;
use yii\rbac\DbManager;
use yii\base\InvalidConfigException;

class m161130_155613_create_rbac_items extends Migration
{
    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }

    public function up()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        $this->insert($authManager->itemTable, [
            'name' => 'user',
            'type' => 1,
            'description' => 'Common user',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert($authManager->itemTable, [
            'name' => 'admin',
            'type' => 1,
            'description' => 'Administrator user',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert($authManager->itemTable, [
            'name' => 'reseller',
            'type' => 1,
            'description' => 'Reseller user',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $query = new Query();
        $query->from('{{%users}}');

        foreach ($query->each() as $user) {
            switch ($user['role_id']) {
                case 1:
                    $role = 'user';
                    break;
                case 2:
                    $role = 'admin';
                    break;
                case 3:
                    $role = 'reseller';
                    break;
            }

            $this->insert($authManager->assignmentTable, [
                'item_name' => $role,
                'user_id' => $user['id'],
                'created_at' => time()
            ]);
        }
    }

    public function down()
    {
        echo "m161130_155613_create_rbac_items cannot be reverted.\n";

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
