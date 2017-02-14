<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', dirname(dirname(dirname(__DIR__))));

defined('SERVICE_ENTRY_URL') or define('SERVICE_ENTRY_URL', parse_url(\Codeception\Configuration::config()['config']['test_entry_url'], PHP_URL_PATH));
defined('SERVICE_ENTRY_FILE') or define('SERVICE_ENTRY_FILE', YII_APP_BASE_PATH . '/service/web/index-test.php');

require_once(YII_APP_BASE_PATH . '/vendor/autoload.php');
require_once(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/Yii.php');
require_once(YII_APP_BASE_PATH . '/common/config/bootstrap.php');
require_once(YII_APP_BASE_PATH . '/service/config/bootstrap.php');

// set correct script paths

// the entry script file path for functional and acceptance tests
$_SERVER['SCRIPT_FILENAME'] = SERVICE_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = SERVICE_ENTRY_URL;
$_SERVER['SERVER_NAME'] =  parse_url(\Codeception\Configuration::config()['config']['test_entry_url'], PHP_URL_HOST);
$_SERVER['SERVER_PORT'] =  parse_url(\Codeception\Configuration::config()['config']['test_entry_url'], PHP_URL_PORT) ?: '80';

Yii::setAlias('@tests', dirname(dirname(__DIR__)));

defined('CONTENTS_URL') or define('CONTENTS_URL', \Codeception\Configuration::config()['config']['test_contents_url']);
defined('CHUNKS_SAMPLES_DIR') or define('CHUNKS_SAMPLES_DIR', __DIR__.'/_chunks_samples');
defined('LOCAL_STORAGE_ROOT') or define('LOCAL_STORAGE_ROOT', \Codeception\Configuration::config()['config']['test_local_storage_root']);
defined('FTP_STORAGE_HOST') or define('FTP_STORAGE_HOST', \Codeception\Configuration::config()['config']['test_ftp_storage_host']);
defined('FTP_STORAGE_PORT') or define('FTP_STORAGE_PORT', \Codeception\Configuration::config()['config']['test_ftp_storage_port']);
defined('FTP_STORAGE_USERNAME') or define('FTP_STORAGE_USERNAME', \Codeception\Configuration::config()['config']['test_ftp_storage_username']);
defined('FTP_STORAGE_PASSWORD') or define('FTP_STORAGE_PASSWORD', \Codeception\Configuration::config()['config']['test_ftp_storage_password']);
defined('FTP_STORAGE_ROOT') or define('FTP_STORAGE_ROOT', \Codeception\Configuration::config()['config']['test_ftp_storage_root']);
defined('MONGO_STORAGE_DSN') or define('MONGO_STORAGE_DSN', \Codeception\Configuration::config()['config']['test_mongo_storage_dsn']);
defined('MONGO_STORAGE_ROOT') or define('MONGO_STORAGE_ROOT', \Codeception\Configuration::config()['config']['test_mongo_storage_root']);
defined('SFTP_STORAGE_HOST') or define('SFTP_STORAGE_HOST', \Codeception\Configuration::config()['config']['test_sftp_storage_host']);
defined('SFTP_STORAGE_PORT') or define('SFTP_STORAGE_PORT', \Codeception\Configuration::config()['config']['test_sftp_storage_port']);
defined('SFTP_STORAGE_USERNAME') or define('SFTP_STORAGE_USERNAME', \Codeception\Configuration::config()['config']['test_sftp_storage_username']);
defined('SFTP_STORAGE_PASSWORD') or define('SFTP_STORAGE_PASSWORD', \Codeception\Configuration::config()['config']['test_sftp_storage_password']);
defined('SFTP_STORAGE_ROOT') or define('SFTP_STORAGE_ROOT', \Codeception\Configuration::config()['config']['test_sftp_storage_root']);
