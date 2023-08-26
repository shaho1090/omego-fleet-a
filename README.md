# omego-fleet-a

## Follow these steps:
- after cloning the repository go to the project directory and run this command:
````
docker compose up -d
````
Go to the app container:
````
docker exec -it omego_app bash
````
Run composer installation:
````
composer install
````
Run Migration:
````
php bin/console doctrine:migrations:migrate
````
Go to following address:
````
localhost:8100/api/docs
````
Register new user and get token using:
````
/api/registration
````
Enter the token you have gotten in the ***Authorize*** button with this pattern:
````
Bearer **token**
````
Now you can use the rest of apis 

