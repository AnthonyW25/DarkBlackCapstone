# DarkBlackCapstone

If you get the “can’t find driver” error when trying to register/login when on localhost:

	•Go into php.ini
	•Find “;extension=pdo_mysql”
	•Remove ;
	•Should work now
	
Heroku app: https://thawing-lowlands-75710.herokuapp.com/

How to run the tests: ./vendor/bin/phpunit ./tests/feature/**insert test filename**

After running tests: php artisan migrate:refresh 
                     php artisan db:seed --class=SalesTableSeeder
                     
If tests are failing: composer dump-autoload


