# withdrawal-from-ATM

## Requirements
- Docker
- Docker Compose

## Run project

### Start Docker's containers
- Execute below command in the terminal / cmd
    ```
    docker-compose up -d
    ```
### Install dependencies 
- Enter to the Apache and PHP container
    ```
    docker exec -it apache_php_atm bash
    ```
- Install required libraries by composer 
    ```
    composer install
    ```
## PhpUnit tests
- Run all test
    ```
    ./vendor/bin/phpunit test/
    ```