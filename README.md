## Requirements
- PHP (v8.1)
- Composer (v2.4.4)
- IDE (VS Code)

## How to Setup?
1. Clone this repository. run `git clone git@github.com:saisarah/TalipaAPP-Backend`
2. Install Composer dependencies. run `composer install`
3. Copy .env.example to .env
4. Open .env and setup your database
5. Generate application. run `php artisan key:generate`
6. Migrate the database. run `php artisan migrate --seed`
7. Start the application run `php artisan serve`