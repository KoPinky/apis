<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProfile($id = null)
    {
        $id = (is_null($id))?(int) auth()->user()->getAuthIdentifier():$id;
        
        $user = User::find($id);
        $Subsc = DB::table('users')
            ->select(['login', 'email'])
            ->leftJoin('subscriptions', 'users.id', '=', 'subscriptions.user_id')
            ->where('subscriptions.user_id', $id)
            ->get();
        $blackList = DB::table('users')
            ->select(['login', 'email'])
            ->leftJoin('black_lists', 'users.id', '=', 'black_lists.user_id')
            ->where('black_lists.user_id', $id)
            ->get();
        return response()->json([ 
            'User' => $user,
            'Subscriptions' => $Subsc,
            'BlackList' => $blackList,
        ]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {

        
        $user =User::find((int) auth()->user()->getAuthIdentifier());
        $user->update($request->all());
        return $user;
    }

    //обновление redis'а
    public function refresh_redis_profile($id)
    {
        
        //запросы    
            $user = User::find($id);

            $Subsc = DB::table('users')
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
                'Subscriptions' => $Subsc,
                'BlackList' => $blackList
            
        ];
        $response = json_encode([
            'Profile' => $profile,
            
        ]);
        Redis::set('User_profile_'.$id, $response);
    }


    public function refresh_redis_posts($id){
        $posts = Post::all()->where('user_id', $id);
        $response = json_encode([
            'posts' => $posts
        ]);
        Redis::set('User_posts_'.$id, $response);
    }
}
