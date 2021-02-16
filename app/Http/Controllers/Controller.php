<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

     //обновление redis'а

    /**
     * @param int $id
     */
     public function refresh_redis_profile(int $id)
     {
         //запросы
             $user = User::find($id);

             $subscription = DB::table('users')
             ->select(['login', 'email'])
             ->leftJoin('subscriptions', 'users.id', '=', 'subscriptions.user_id')
             ->where('subscriptions.user_id', $id)
             ->get();

             $blackList = DB::table('users')
             ->select(['login', 'email'])
             ->leftJoin('black_lists', 'users.id', '=', 'black_lists.user_id')
             ->where('black_lists.user_id', $id)
             ->get();

         // сборщик ответа
         $profile = [
                 'User' => $user,
                 'Subscriptions' => $subscription,
                 'BlackList' => $blackList
         ];
         $response = json_encode([
             'Profile' => $profile,
         ]);
         Redis::set('user_profile_'.$id, $response);
     }

    /**
     * @param int $id
     */
     public function refresh_redis_posts(int $id)
     {
        $posts = Post::query()->where('user_id', $id)->get();
        $response = json_encode([
            'posts' => $posts
        ]);
        Redis::set('user_posts_'.$id, $response);
     }
}
