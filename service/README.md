## PLG service setup  ##

 1. Upload project to server.
 2. Initialize application `yii init`.
 3. Check database configuration in *common/config/main-local.php*.
 4. Check service parameters in *service/config/parms.php*. Check if all parameters belove are set *serviceUid*, *serviceName*, *encryptKey*, *useragentXml*, *proxiesXml*. Also make sure files *useragentXml* and *proxiesXml* exist and are readable.
 5. Check service configuration in *service/config/main.php*, *service/config/main-local.php*.
 6. Apply all migrations `yii migrate --migrationPath=service/migrations`.
 7. Make sure field *uid* in *instances* table has same value as *serviceUid* parameter (see *service/config/paarms.php*).
 8. Set value *app_api_url* in *instances* table.
 9. Add service to *services* table in web app DB.

 ## Requierments ##

 - PHP 5.6.x or newer
 - V8Js PHP extension (used in some content providers)
 - MongoDb PHP extension (used in mongodb storage)
 - SSH2 PHP extension (used in sftp storage)
 - MySQL 5.6.33 or newer
 - Apache / Nginx
