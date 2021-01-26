<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//posts
// CRUD

// 1. get all(GET)  /api/posts
// 2. create a post(POST)   /api/posts
// 3. get a single(GET) /api/posts/{id}
// 4. update a single (PUT/PATCH)   /api/posts/{id}
// 5. dalete (delete)   /api/posts/{id}

Route::get('/posts');


// to create resurces in laravel
// 1. create a database and migration
// 2. create a model
// 2.5 create a service? Elaquement ORM
// 3. create a controller to go get info from the database
// 4. return thet info

Route::get('/test-api', function(){
    return ['message' => 'hello'];
});