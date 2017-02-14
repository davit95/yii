<?php

use yii\db\Migration;

class m160421_085652_add_column_users_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%users}}', 'role_id', 'INTEGER DEFAULT "2" NOT NULL AFTER `id`');
        $this->addForeignKey('fk_users_role_id','{{%users}}','role_id','{{%roles}}','id');

        $timmestamp = time();

        try {
            $this->insert('{{%users}}', [
                'role_id' => 2,
                'auth_key' => '',
                'password_hash' => Yii::$app->security->generatePasswordHash('
                admin123456'),
                'password_reset_token' => Yii::$app->security->generateRandomString() . '_' . time(),
                'access_token' =>'',
                'email' => 'plg@admin.com',
                'status' => 1,
                'created_at' => $timmestamp,
                'updated_at' => $timmestamp,
            ]);
        } catch (Exception $e) {
            
        }
        $this->createIndex(
            'idx_users_role_id',
            '{{%users}}',
            'role_id'
        );

    }

    public function down()
    {
        $this->delete('{{%users}}',['role_id' => 1, 'email' =>'plg@admin.com']);

        $this->dropForeignKey('fk_users_role_id',"{{%users}}");

        $this->dropColumn('{{%users}}','role_id');
    }
}