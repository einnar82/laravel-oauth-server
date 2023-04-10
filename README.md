## Laravel OAuth2 Server

**Prerequisites:**
- Docker
- PHP 8.2

**Setup Instructions:**

- Copy the `.env.example` into `.env`

- Install dependencies.
```shell  
	composer install
```
-  Start the development server.

```shell  
	./vendor/bin/sail up -d
```

- Run passport install command.
```shell  
	./vendor/bin/sail artisan passport:install
```
- Run migrations and seeders.
```shell  
	./vendor/bin/sail artisan migrate && ./vendor/bin/sail artisan db:seed
```
To run the tests, update the `.env.testing` and on your terminal type
```shell  
	./vendor/bin/sail artisan test
```
