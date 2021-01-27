<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use denis660\Centrifugo\Centrifugo;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    private $centrifugo;

    public function __construct(Centrifugo $centrifugo)
    {
        $this->centrifugo = $centrifugo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*
    public function index()
    {
        
        return Post::all()->take(50);
    }
*/
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate
        
        $request->validate([
            'theme' => 'required',
            'text' => 'required',
            'user_id' => 'required',
        ]);

        
        
        
        //create a post
        $post = Post::create($request->all());
        $arr =Post::all();
        $this->centrifugo->publish('posts', ["posts" => $arr]);
        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
    {
        //show a post 
        return Post::find($id)->where('user_id', $id);
    }

    public function wall($id)
    {
        
        //show a post 
        $wall = DB::table('posts')
        ->leftJoin('subscriptions', 'posts.user_id', '=', 'subscriptions.user_id')
        ->leftJoin('users', 'users.id', '=', 'subscriptions.user_id')
        ->where('user_id', $id)
        ->where('subscriptions.added_id', $id)
        ;
        return $wall;

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    //закрыты на тех работы ибо оно не нужно
    /*
    public function update(Request $request, $id)
    {
        //update a post 

        $post = Post::find($id);
        $post->update($request->all());
        $arr =Post::all();
        $this->centrifugo->publish('posts', ["posts" => $arr]);
        return $post;
    }
    */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete a post 
        $post = Post::destroy($id);
        $arr =Post::all();
        $this->centrifugo->publish('posts', ["posts" => $arr]);
        return $post;
    }
}
