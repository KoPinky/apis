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
    Route::middleware('auth:api')->post('user', [UserController::class, 'updateProfile']);//обновление своего профиля

    //все для постов
    Route::middleware('auth:api')->get('posts', [PostController::class, 'show']);// просмотр своих постов авторизованным пользователем
    Route::middleware('auth:api')->get('posts/{id}', [PostController::class, 'show']);// просмотр чужих постов авторизованным пользователем
    Route::middleware('auth:api')->post('posts', [PostController::class, 'store']);// создание поста авторизованным пользователем
    Route::middleware('auth:api')->delete('posts/{id}', [PostController::class, 'destroy']);// удаление поста авторизованным пользователем
    Route::middleware('auth:api')->get('users/wall', [PostController::class, 'wall']); 
    
    //все для коментов
    Route::middleware('auth:api')->post('comments', [CommentController::class, 'store']);//создание коментария
    Route::middleware('auth:api')->delete('comments/{id}', [CommentController::class, 'destroy']); //удаление коментария

    
    //все для блэк листа
    Route::middleware('auth:api')->get('blackList/{id}', [BlackListController::class, 'check']);// проверка на нахождение в черном списке
    Route::middleware('auth:api')->post('blackList', [BlackListController::class, 'store']); //добавление в черный список
    
    //все для подписания
    Route::middleware('auth:api')->post('subscription', [SubscriptionController::class, 'store']);//подписапться на кого либо
    
    // не тестил
    
    
    
    
    //log out на всякий случай
    /*
    Route::get('logOut', function(){
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    });
    */
});