<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Getting started
Installation
Please check the official laravel installation guide for server requirements before you start.<a href="https://laravel.com/"> Official Documentation</a>

Alternative installation is possible without local dependencies relying on Docker.

Clone the repository
```bash
git clone https://github.com/KoPinky/apis.git
```
Switch to the repo folder
```bash
cd apis
```
Install all the dependencies using composer
```bash
composer install
```
Copy the example env file and make the required configuration changes in the .env file
```bash
cp .env.example .env
```
Generate a new application key
```bash
php artisan key:generate
```
Generate a new JWT authentication secret key
```bash
php artisan jwt:generate
```
Run the database migrations (Set the database connection in .env before migrating)
```bash
php artisan migrate
```
Start the local development server
```bash
php artisan serve
```
You can now access the server at http://localhost:8000