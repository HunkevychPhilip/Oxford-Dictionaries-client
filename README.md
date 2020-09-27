# Requirements
* PHP 7.3
* composer

# How to install
* Clone to your local repository
* `cd` into cloned repository folder
* Execute in terminal `composer install`
* Execute `php -S localhost:8000 -t public/` for php built-in server or `symfony serve` if you're using Symfony
* Don't forget to enter your `API_ID` and `API_KEY` inside `.env` file. You can get them after the registration on the https://developer.oxforddictionaries.com.
# Tests
* If you didn't execute `composer install` — `cd` into cloned repository folder and do it
* Execute `./vendor/bin/simple-phpunit` (it might take some time at first)
* In order to pass the tests correctly you should have valid `API_ID` and `API_KEY`
