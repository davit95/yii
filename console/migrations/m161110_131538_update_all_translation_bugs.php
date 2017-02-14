<?php

use yii\db\Migration;

class m161110_131538_update_all_translation_bugs extends Migration
{
    public function up()
    {
        $source = [
    	   ['category' => 'contact_us_button', 'message' => 'Send'],
           ['category' => 'contact_us_button', 'message' => 'Follow us on Facebook'],
           ['category' => 'uptime_and_overview', 'message' => 'File Hosts'],
           ['category' => 'uptime_and_overview', 'message' => 'Last Check'],
           ['category' => 'suported_payment_methods', 'message' => 'Supported Payment methods'],
           ['category' => 'how_it_works', 'message' => 'Inside the box'],
           ['category' => 'how_it_works', 'message' => 'Press the'],
           ['category' => 'how_it_works', 'message' => 'or'],
           ['category' => 'how_it_works', 'message' => 'Join now'],
           ['category' => 'how_it_works', 'message' => 'Join Today and download EVERYTHING from EVERYWHERE {tag} {host_number} File Hosts in one Account'],
           ['category' => 'how_it_works', 'message' => 'Create Account'],

           //static pages
            ['category' => 'auth', 'message' => 'Login to'],
            ['category' => 'auth', 'message' => 'Remember Me'],
            ['category' => 'auth', 'message' => 'You don`t have an account? {link_registr}'],
            ['category' => 'auth', 'message' => 'Create account'],
            ['category' => 'auth', 'message' => 'Just enter your email address below, which will also be your login name for Premium {tag}  Link Generator, and choose your password!'],
            ['category' => 'auth', 'message' => 'I agree to Premium Link Generator Terms'],
            ['category' => 'auth', 'message' => 'If you already have an account {link_login}'],

            //user profile
            ['category' => 'user_profile', 'message' => 'Download Now'],
            ['category' => 'user_profile', 'message' => 'My Account'],
            ['category' => 'user_profile', 'message' => 'Add Credits'],
            ['category' => 'user_profile', 'message' => 'Referal'],
            ['category' => 'user_profile', 'message' => 'Transactions'],
            ['category' => 'user_profile', 'message' => 'Forum'],
            ['category' => 'user_profile', 'message' => 'My Downloads'],
            ['category' => 'user_profile', 'message' => 'Payment Details'],
            ['category' => 'user_profile', 'message' => 'Uptime and Overview'],
        ];

        $source_translations = [
            [
                ['language' => 'ru', 'translation' => 'Послать'],
                ['language' => 'en', 'translation' => 'Send'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Следите за нами на Фейсбуке'],
                ['language' => 'en', 'translation' => 'Follow us on Facebook'],
            ],
            [
                ['language' => 'ru', 'translation' => 'файлообменники'],
                ['language' => 'en', 'translation' => 'File Hosts'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Последняя проверка'],
                ['language' => 'en', 'translation' => 'Last Check'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Поддерживаемые способы оплаты'],
                ['language' => 'en', 'translation' => 'Supported Payment methods'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Внутри коробки'],
                ['language' => 'en', 'translation' => 'Inside the box'],
            ],
            [
                ['language' => 'ru', 'translation' => 'нажмите'],
                ['language' => 'en', 'translation' => 'Press the'],
            ],
            [
                ['language' => 'ru', 'translation' => 'или'],
                ['language' => 'en', 'translation' => 'or'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Присоединяйся'],
                ['language' => 'en', 'translation' => 'Join now'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Присоединяйтесь сегодня и скачать ВСЁ Отовсюду {tag} {host_number} файла хостов в одной учетной записи'],
                ['language' => 'en', 'translation' => 'Join Today and download EVERYTHING from EVERYWHERE {tag} {host_number} File Hosts in one Account'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Регистрация'],
                ['language' => 'en', 'translation' => 'Create Account'],
            ],

            //static pages
            [
                ['language' => 'ru', 'translation' => 'Войти в'],
                ['language' => 'en', 'translation' => 'Login to'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Запомни меня'],
                ['language' => 'en', 'translation' => 'Remember Me'],
            ],
            [
                ['language' => 'ru', 'translation' => 'У вас нет аккаунта? {link_registr}'],
                ['language' => 'en', 'translation' => 'You don`t have an account? {link_registr}'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Создать Аккаунт на'],
                ['language' => 'en', 'translation' => 'Create account on'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Просто введите ниже адрес электронной почты, который будет также ваше имя Войти для премиум {tag} Link Generator, и выбрать пароль!'],
                ['language' => 'en', 'translation' => 'Just enter your email address below, which will also be your login name for Premium {tag}  Link Generator, and choose your password!'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Я согласен Премиум Ссылка Generator Условия'],
                ['language' => 'en', 'translation' => 'I agree to Premium Link Generator Terms'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Если у вас уже есть учетная запись {link_login}'],
                ['language' => 'en', 'translation' => 'If you already have an account {link_login}'],
            ],
            //user profile 
            [
                ['language' => 'ru', 'translation' => 'Скачать сейчас'],
                ['language' => 'en', 'translation' => 'Download Now'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Мой аккаунт'],
                ['language' => 'en', 'translation' => 'My Account'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Добавить кредиты'],
                ['language' => 'en', 'translation' => 'Add Credits'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Реферал'],
                ['language' => 'en', 'translation' => 'Referal'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Транзакции'],
                ['language' => 'en', 'translation' => 'Transactions'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Форум'],
                ['language' => 'en', 'translation' => 'Forum'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Мои Загрузки'],
                ['language' => 'en', 'translation' => 'My Downloads'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Детали оплаты'],
                ['language' => 'en', 'translation' => 'Payment Details'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Провел и Обзор'],
                ['language' => 'en', 'translation' => 'Uptime and Overview'],
            ],
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
        echo "m161110_131538_update_all_translation_bugs cannot be reverted.\n";

        return false;
    }
}
