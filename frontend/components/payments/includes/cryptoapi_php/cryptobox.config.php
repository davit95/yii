<?php
/**
 *  ... Please MODIFY this file ...
 *
 *
 *  YOUR MYSQL DATABASE DETAILS
 *
 */

 define("DB_HOST", 	"localhost");				// hostname
 define("DB_USER", 	"root");		// database username
 define("DB_PASSWORD", 	"root");		// database password
 define("DB_NAME", 	"plg");	// database name




/**
 *  ARRAY OF ALL YOUR CRYPTOBOX PRIVATE KEYS
 *  Place values from your gourl.io signup page
 *  array("your_privatekey_for_box1", "your_privatekey_for_box2 (otional), etc...");
 */

 $cryptobox_private_keys = array("7570AAAQBcsBitcoin77BTCPRV8zwZ8yapm72gMZvvm3oOzzIm");




 define("CRYPTOBOX_PRIVATE_KEYS", implode("^", $cryptobox_private_keys));
 unset($cryptobox_private_keys);

?>
