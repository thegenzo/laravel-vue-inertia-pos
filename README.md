
# Laravel Vue Inertia POS

Point Of Sales (POS) develop with Laravel 9 as back-end and Vue 3 as front-end with Inertia.js as adapter to create modern monolith fullstack application



![alt text](https://github.com/thegenzo/laravel-vue-inertia-pos/blob/main/image.png?raw=true)
## Features

- CRUD Categories
- CRUD Products
- CRUD Customers
- CRUD Users 
- Transactions
- Report Sales
- Report Profits
- Roles and Permissions

## Installation

### Laravel and Vue

Install this-project project with
``` composer install ``` and ``` npm install ``` to the root folder of project

### Database Setup

 - Create your database first at Phpmyadmin panel and define it on ```.env``` files on  ```DB_DATABASE``` value

 - Run ```php artisan migrate --seed``` command

### Run

run ```php artisan serve``` on first terminal and ```npm run watch``` on second terminal and open ```localhot:8000``` in your browser

admin: admin@gmail.com, password: password
