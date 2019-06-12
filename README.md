## Qitsune
#### Qitsune is a Laravel 5.5 Application with which you can Play a game
[![Build Status](https://travis-ci.org/Chronyms/Qitsune.svg?branch=dev_v2)](https://travis-ci.org/Chronyms/Qitsune)
[![StyleCI](https://github.styleci.io/repos/101512980/shield?branch=dev_v2)](https://github.styleci.io/repos/101512980)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chronyms/qitsune/badges/quality-score.png?b=dev_v2)](https://scrutinizer-ci.com/g/chronyms/qitsune/?branch=dev_v2)
[![Build Status](https://scrutinizer-ci.com/g/chronyms/qitsune/badges/build.png?b=dev_v2)](https://scrutinizer-ci.com/g/chronyms/qitsune/build-status/dev_v2) [![Greenkeeper badge](https://badges.greenkeeper.io/Vento-Nuenenen/Qitsune.svg)](https://greenkeeper.io/)


| Qitsune built on  |
| :------------ |
|Built on [Laravel](http://laravel.com/) 5.6|
|Uses [MySQL](https://github.com/mysql) Database|
|Uses [Artisan](http://laravel.com/docs/5.6/artisan) to manage database migration, schema creations, and create/publish page controller templates|
|Dependencies are managed with [COMPOSER](https://getcomposer.org/)|
|Laravel Scaffolding **User** and **Administrator Authentication**.|
|CRUD (Create, Read, Update, Delete) User Management|
|Makes us of [Password Strength Meter](https://github.com/elboletaire/password-strength-meter)|
|Makes use of [hideShowPassword](https://github.com/cloudfour/hideShowPassword)|
|User [Roles/ACL Implementation](https://github.com/jeremykenedy/laravel-roles)|
|Makes of [Laravel's Soft Delete Structure](https://laravel.com/docs/5.6/eloquent#soft-deleting)|
|Soft Deleted Users Management System|
|Permanently Delete Soft Deleted Users|
|User Delete Account with Goodbye email|
|User Restore Deleted Account Token|
|Restore Soft Deleted Users|
|View Soft Deleted Users|
|Captures Soft Delete Date|
|Captures Soft Delete IP|
|Admin Routing Details UI|
|Admin PHP Information UI|
|Eloquent user profiles|
|User Themes|
|404 Page|
|403 Page|
|User Delete with Goodby email|
|User Restore Deleted Account|
|Activity Logging using [Laravel-logger](https://github.com/jeremykenedy/laravel-logger)|

### Installation Instructions
1. Run `git clone https://github.com/jeremykenedy/laravel-auth.git laravel-auth`
2. Create a MySQL database for the project
    * ```mysql -u root -p```, if using Vagrant: ```mysql -u homestead -psecret```
    * ```create database laravelAuth;```
    * ```\q```
3. From the projects root run `cp .env.example .env`
4. Configure your `.env` file
5. Run `composer update` from the projects root folder
6. From the projects root folder run:
```
php artisan vendor:publish --tag=laravelroles &&
php artisan vendor:publish --tag=laravel2step
```
7. From the projects root folder run `sudo chmod -R 755 ../laravel-auth`
8. From the projects root folder run `php artisan key:generate`
9. From the projects root folder run `php artisan migrate`
10. From the projects root folder run `composer dump-autoload`
11. From the projects root folder run `php artisan db:seed`
12. Compile the front end assets with [npm steps](#using-npm) or [yarn steps](#using-yarn).

#### Build the Front End Assets with Mix
##### Using NPM:
1. From the projects root folder run `npm install`
2. From the projects root folder run `npm run dev` or `npm run production`
  * You can watch assets with `npm run watch`

##### Using Yarn:
1. From the projects root folder run `yarn install`
2. From the projects root folder run `yarn run dev` or `yarn run production`
  * You can watch assets with `yarn run watch`

###### And thats it with the caveat of setting up and configuring your development environment. I recommend [Laravel Homestead](https://laravel.com/docs/5.6/homestead)

### Seeds
##### Seeded Roles
  * Unverified - Level 0
  * User  - Level 1
  * Administrator - Level 5

##### Seeded Permissions
  * view.users
  * create.users
  * edit.users
  * delete.users

### Routes

#### Authentication Routes
* ```/login```
* ```/logout```
* ```/register```
* ```/password/email```
* ```/password/reset```
* ```/activate```
* ```/activate/{token}```
* ```/activation-required```
* ```/re-activate/{token}```

#### Profile Routes
* ```/profile/{username}```
* ```/profile/{username}/edit``` <- Editing in this view is limited to current user only.

#### Admin User Management Routes
* ```/users```
* ```/users/create```
* ```/users/{user_id}```
* ```/users{user_id}/edit```

#### Admin Theme Routes
* ```/themes```
* ```/themes/create```
* ```/themes/{theme_id}```
* ```/themes/{theme_id}/edit```

#### Admin Tools Routes
* ```/logs```
* ```/phpinfo```
* ```/routes```

#### Admin Soft Deleted Users Management Routes
* ```/users/deleted```
* ```/users/deleted/{user_id}```

#### Activity Log Routes
* ```/activity```
* ```/activity/cleared```
* ```/activity/log/{id}```
* ```/activity/cleared/log/{id}```
