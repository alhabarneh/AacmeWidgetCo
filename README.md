# Acme Widget Co
This is a sales system for Acme Widget Co

# How to get started
You will need docker installed in your machine to build and up the container.
> docker-compose up -d
> composer install

# How to run the unit tests
First you would need to exec into the docker container
> docker exec -it acme
> ./vendor/bin/phpunit --verbose tests

To run a specific unit test file run the following command
> ./vendor/bin/phpunit --verbose tests/Unit/OrderServiceTest.php
