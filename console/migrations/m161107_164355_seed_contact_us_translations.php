<?php

use yii\db\Migration;

class m161107_164355_seed_contact_us_translations extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        //Translation data-testing,words is not correct
        //Trasnlation will by updated dynamicly from admin panel
        $source = [
            ['category' => 'contact_us', 'message' => 'Contact Us'],
            ['category' => 'contact_us', 'message' => 'Values we stand for'],
            ['category' => 'contact_us', 'message' => 'Real and secure privacy'],
            ['category' => 'contact_us', 'message' => 'Are you often out, surfing in cafes, railway stations or airports? Thats an invitation for data thieves. Save your networks, your identity, bank and credit card data. All Internet connections are encrypted using up to 256-bit - so no one will get your data.'],
            ['category' => 'contact_us', 'message' => 'Absolutely reliable'],
            ['category' => 'contact_us', 'message' => 'We don’t know cheapy, just low cost for value! While selecting our infrastructure, we look for the highest quality you can get in our worldwide server - network. Access to all sites is well protected against unauthorized access'],
            ['category' => 'contact_us', 'message' => 'Full cost control'],
            ['category' => 'contact_us', 'message' => 'No ongoing subscription, with us you only pay for the product you chose. Risk free and absolutely transparent.'],
            ['category' => 'contact_us', 'message' => 'If you have a question feel free to contact us'],
            ['category' => 'contact_us', 'message' => 'E-mail address'],
            ['category' => 'contact_us', 'message' => 'Subject'],
            ['category' => 'contact_us', 'message' => 'Message'],
            ['category' => 'contact_us', 'message' => 'Antibot'],
        ];

        $source_translations = [
            [
                ['language' => 'ru', 'translation' => 'Oбратная связь'],
                ['language' => 'en', 'translation' => 'Contact Us'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Значения мы стоим'],
                ['language' => 'en', 'translation' => 'Values we stand for'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Реальный и безопасный конфиденциальности'],
                ['language' => 'en','translation'=>'Real and secure privacy'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Вы часто из, серфинг в кафе, на вокзалах или в аэропортах? То приглашение для воров данных. Сохраните свои сети, вашу личность, банковские и кредитные карты данных. Все Интернет-соединения шифруются с использованием до 256-бит - так что никто не получит свои данные.'],
                ['language' => 'en','translation'=>'Are you often out, surfing in cafes, railway stations or airports? Thats an invitation for data thieves. Save your networks, your identity, bank and credit card data. All Internet connections are encrypted using up to 256-bit - so no one will get your data.'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Абсолютно надежная'],
                ['language' => 'en','translation'=>'Absolutely reliable'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Мы не знаем, просто cheapy низкая стоимость по стоимости! При выборе нашей инфраструктуры, мы ищем самого высокого качества вы можете получить на нашем сервере по всему миру - сеть. Доступ ко всем сайтам, хорошо защищена от несанкционированного доступа'],
                ['language' => 'en','translation'=>'We don’t know cheapy, just low cost for value! While selecting our infrastructure, we look for the highest quality you can get in our worldwide server - network. Access to all sites is well protected against unauthorized access'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Полный контроль над расходами'],
                ['language' => 'en','translation'=>'Full cost control'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Нет текущей подписки, с нами, Вы платите только за продукт, который вы выбираете. Риск бесплатно и абсолютно прозрачно.'],
                ['language' => 'en','translation'=>'No ongoing subscription, with us you only pay for the product you chose. Risk free and absolutely transparent.'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Если у вас есть вопросы, не стесняйтесь связаться с нами'],
                ['language' => 'en','translation'=>'If you have a question feel free to contact us'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Адрес электронной почты'],
                ['language' => 'en','translation'=>'E-mail address'],
            ],
            [
                ['language' => 'ru', 'translation' => 'субъект'],
                ['language' => 'en','translation'=>'Subject'],
            ],
            [
                ['language' => 'ru', 'translation' => 'сообщение'],
                ['language' => 'en','translation'=>'Message'],
            ],
            [
                ['language' => 'ru', 'translation' => 'Анти Бот'],
                ['language' => 'en','translation'=>'Antibot'],
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
        echo "m161107_164355_seed_contact_us_translations cannot be reverted.\n";

        return false;
    }
}
