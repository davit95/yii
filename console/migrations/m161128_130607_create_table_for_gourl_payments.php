<?php

use yii\db\Migration;

class m161128_130607_create_table_for_gourl_payments extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE `crypto_payments` (
        	  `paymentID` int(11) unsigned NOT NULL AUTO_INCREMENT,
        	  `boxID` int(11) unsigned NOT NULL DEFAULT '0',
        	  `boxType` enum('paymentbox','captchabox') NOT NULL,
        	  `orderID` varchar(50) NOT NULL DEFAULT '',
        	  `userID` varchar(50) NOT NULL DEFAULT '',
        	  `countryID` varchar(3) NOT NULL DEFAULT '',
        	  `coinLabel` varchar(6) NOT NULL DEFAULT '',
        	  `amount` double(20,8) NOT NULL DEFAULT '0.00000000',
        	  `amountUSD` double(20,8) NOT NULL DEFAULT '0.00000000',
        	  `unrecognised` tinyint(1) unsigned NOT NULL DEFAULT '0',
        	  `addr` varchar(34) NOT NULL DEFAULT '',
        	  `txID` char(64) NOT NULL DEFAULT '',
        	  `txDate` datetime DEFAULT NULL,
        	  `txConfirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
        	  `txCheckDate` datetime DEFAULT NULL,
        	  `processed` tinyint(1) unsigned NOT NULL DEFAULT '0',
        	  `processedDate` datetime DEFAULT NULL,
        	  `recordCreated` datetime DEFAULT NULL,
        	  PRIMARY KEY (`paymentID`),
        	  KEY `boxID` (`boxID`),
        	  KEY `boxType` (`boxType`),
        	  KEY `userID` (`userID`),
        	  KEY `countryID` (`countryID`),
        	  KEY `orderID` (`orderID`),
        	  KEY `amount` (`amount`),
        	  KEY `amountUSD` (`amountUSD`),
        	  KEY `coinLabel` (`coinLabel`),
        	  KEY `unrecognised` (`unrecognised`),
        	  KEY `addr` (`addr`),
        	  KEY `txID` (`txID`),
        	  KEY `txDate` (`txDate`),
        	  KEY `txConfirmed` (`txConfirmed`),
        	  KEY `txCheckDate` (`txCheckDate`),
        	  KEY `processed` (`processed`),
        	  KEY `processedDate` (`processedDate`),
        	  KEY `recordCreated` (`recordCreated`),
        	  KEY `key1` (`boxID`,`orderID`),
        	  KEY `key2` (`boxID`,`orderID`,`userID`),
        	  KEY `key3` (`boxID`,`orderID`,`userID`,`txID`)
        	) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
        ");
    }

    public function down()
    {
        echo "m161128_130607_create_table_for_gourl_payments cannot be reverted.\n";

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
