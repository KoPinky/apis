<?php

use App\Http\Controllers\CommentController;
use App\Models\Post;
use App\Http\Controllers\PostController;
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

Route::prefix('v1')->group(function(){

    Route::apiResource('posts', 'App\Http\Controllers\PostController');

    Route::get('post/{id}/comments', [CommentController::class, 'index']);

    Route::post('comments', [CommentController::class, 'store']);

    Route::delete('comments/{commentId}', [CommentController::class, 'destroy']);
});

//this  will also return a post object




// to create resurces in laravel
// 1. create a database and migration
// 2. create a model
// 2.5 create a service? Elaquement ORM
// 3. create a controller to go get info from the database
// 4. return thet info


Route::middleware('auth:api')->get('/user', function(Request $request){
    return $request->user();
});
/*
Route::get('/posts', 'PostController@index');
Route::post('/posts', 'PostController@store');
Route::put('/posts', 'PostController@update');
Route::delete('/posts', 'PostController@destroy');
Route::get('/posts', 'PostController@index');
Route::get('/posts', 'PostController@index');

Route::get('/posts', function(){
    $post = Post::create([
        'title' => 'my first post', 
        'slug' => 'my-first-post'
        ]);

    return $post;
});


//create route
Route::post('/posts');


//update route
Route::put('/posts/{id}');

//delete route
Route::delete('/posts/{id');


    Route::get('/test-api', function(){
    return ['message' => 'hello'];
});
*/