<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BlackListController;
use App\Http\Controllers\CommentController;
use App\Models\Post;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    //РАБОТАЮЩИЕ МЕТОДЫ XD:)
    
    //Все для авторизации
    Route::post('auth', [AccountController::class, 'auth']);
    Route::post('register', [AccountController::class, 'register']);


    //все для профилей
    Route::middleware('auth:api')->get('profile', [UserController::class, 'showProfile']);//показать профиль авторизовнного пользователя
    Route::middleware('auth:api')->post('user', [UserController::class, 'updateProfile']);

    //все для постов
    Route::middleware('auth:api')->post('posts', [PostController::class, 'store']);// создание поста авторизованным пользователем
    Route::middleware('auth:api')->delete('posts', [PostController::class, 'destroy']);
    


    Route::middleware('auth:api')->get('users/{id}/wall', [PostController::class, 'wall']); 
    
    
    
    Route::post('comments', [CommentController::class, 'store']);
    
    
    // не тестил
    Route::get('users/{id}/posts', [PostController::class, 'show']);
    
    
    
    //Route::apiResource('users', 'App\Http\Controllers\UserController');
    
    Route::get('logOut', function(){
        Auth::logout();
        return 'you\'re log out';
    });
    Route::get('ch0', function(){
        
        return Auth::check()? 'true': 'false';
    });
    Route::get('post/{id}/comments', [CommentController::class, 'index']);
    

    Route::post('blackList', [BlackListController::class, 'store']);
    Route::post('blackListCheck', [BlackListController::class, 'check']);

    Route::post('Subscription', [SubscriptionController::class, 'store']);
});

//this  will also return a post object
//все для авторизации
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');

});


// to create resurces in laravel
// 1. create a database and migration
// 2. create a model
// 2.5 create a service? Elaquement ORM
// 3. create a controller to go get info from the database
// 4. return thet info

//ОТСТОЙНИК
/*

*/



/*
Route::middleware('auth:api')->get('/user', function(Request $request){
    return $request->user();
});



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