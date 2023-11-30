# Scribble

## Installation

* First clone this project: `git clone https://github.com/BjornValk78/scribble.git .`
* Run `composer install` in the root directory of the cloned project. This will import the PHP dependencies into `\vendor`.
* Edit the .env file database credentials with your database server, username and password.
* Run `scribble:setup` to initiate the application.
* Run `symfony server:start` to start local symfony web server

## Handle messages

* Run `scribble:handle` to handle all pending messages.

## Running unit tests

Before you can run the unit tests you need to initialize the test database.
* Run `php bin/console doctrine:database:create --env=test` to create a database for the test environement.
* Run `php bin/console doctrine:schema:create --env=test ` to create the database schema for the test environement.
* Run `php bin/console doctrine:fixtures:load -n --env=test` to load the data fixtures in the test database.
* 