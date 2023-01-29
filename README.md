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
7. Link public storage. run `php artisan storage:link`
8. Start the application run `php artisan serve`

## Terminologies
1. 

## FAQs

### What is .env file?
- The .env file contains configuration that is specific for environment, such as database connection.

## Commands Cheat Sheet

### Git Cheat Sheet

1. `git add [files or folder]` to add changes in staging area
2. `git commit -m "[Commit Message]"` to commit changes in history
3. `git push -u origin [branch name]` to create and push to a remote branch
4. `git push` to push local branch to remote branch
5. `git switch [branch]` to switch to a different branch
6. `git switch - `  to switch back to the previous branch
7. `git switch -c [branch]` to create and switch to a new branch

Laravel Commands

1. `php artisan serve` to serve the application
2. `php artisan migrate:fresh` this command will drop all the tables and re import the tables
3. `php artisan db:seed` this command wlll populate the datatabase.
