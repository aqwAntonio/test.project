Инструкция по развороту проекта:

git clone git@github.com:aqwAntonio/test.project.git

cd test.project

php74 ./composer.phar update

mv .env.example .env

nano .env (set DB_CONNECTION=pgsql and etc...)

php74 artisan migrate

php74 artisan db:seed --class=PermissionTableSeeder

php74 artisan db:seed --class=CreateAdminUserSeeder

php74 artisan db:seed --class=CreateClientUserSeeder

php74 artisan serve

open http://127.0.0.1:8000

enter as an admin (login admin@example.org, password 123456)
