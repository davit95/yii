This directory contains tests for service application

1. Update configurations in `codeception.yml`.
2. Update configurations in `config/config.php`. Make sure db alias is configured to test database.
3. Update configurations in `config/service/config.php`.
4. Apply migrations to test database:
    ```
    yii migrate --migrationPath=service/migrations --db=plg.test
    ```
5. Run `codecept run` from `codeception/service` directory.
