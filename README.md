# Building Application without Docker

## Copy .env file
```cp .env.example .env```
## Generate Application key
```php artisan key:generate```
## Run migrations
```php artisan migrate```
## Start worker for queue
```php artisan queue:work```
## Start scheduler
```php artisan schedule:work```

# Building Application with Docker
## Build containers
```docker-compose up --build -d```
## Run migrations
```docker-compose exec web php artisan migrate```

# Application Information

Go to http://localhost:8000 or use Postman for testing.
Application documentation you can find in swagger.yml file or you can ask me in person.
