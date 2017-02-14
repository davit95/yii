<?php

use yii\db\Migration;
use yii\db\Query;

class m161101_140814_seed_data_to_source_messages_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $source = [
            ['category' => 'site', 'message' => 'Home'],
            ['category' => 'site', 'message' => 'My Account'],
            ['category' => 'site', 'message' => 'How does it works'],
            ['category' => 'site', 'message' => 'Uptime & Overview'],
            ['category' => 'site', 'message' => 'Supported File Hosts'],
            ['category' => 'site', 'message' => 'Pricing'],
            ['category' => 'site', 'message' => 'Sign Up'],
            ['category' => 'site', 'message' => 'Log In'],
            ['category' => 'site', 'message' => 'Log Out'],
            ['category' => 'site', 'message' => 'Download Everything With One Account'],
        ];

        $source_translations = [
            [
                ['language' => 'ru', 'translation' => 'Главная'],
                ['language' => 'en', 'translation' => 'Home'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Моя страница'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Как это работает'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Провел и Обзор'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Поддерживаемые файлообменников'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Ценообразование'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Регистрация'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Логин'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Выйти'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Скачать все с одним аккаунтом'],
            ]
        ];

        for ($i = 0; $i < count($source); $i++) {
            $data = $this->insert('{{%source_message}}',$source[$i]);
            $id = Yii::$app->db->getLastInsertID();
            foreach ($source_translations[$i] as $key) {
                Yii::$app->db->createCommand('INSERT INTO `message` (`id`,`language`,`translation`) VALUES (:id,:language,:translation)', [
                    ':id' => $id,
                    ':language' => $key['language'],
                    ':translation'=>$key['translation'],
                ])->execute();                            
            }            
        }
    }
    public function down()
    {
        echo "m161101_140814_seed_data_to_source_messages_table cannot be reverted.\n";

        return false;
    }
}
