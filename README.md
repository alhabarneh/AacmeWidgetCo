# Acme Widget Co
This is a sales system for Acme Widget Co

## How to get started
### How to build the docker containers
There are two containers
- **app** for the platform code (php)
- **database** for mysql
You will need docker installed in your machine to build and up the container.
```
docker-compose up -d
docker exec -it acme
composer install
```

### How to run the unit tests
First you would need to exec into the docker container
```
docker exec -it acme
./vendor/bin/phpunit tests/Unit
```

To run a specific unit test file run the following command
```
./vendor/bin/phpunit tests/Unit/OrderServiceTest.php
```
## App Structure
The app is an MVC System split between (Models, Views, Controllers and also Services).
I used the following in my code:
- Dependency Injection Pattern.
- Strategy Pattern.
- Separation and Encapsulation.
- Composer.
- PHPUnit.
- Docker and Docker compose.
- Sensible types.
- Source control (git) and code review in a PR.
- Interfaces.
- Controllers, Models, Helpers (database helper), Services (OrderService).
