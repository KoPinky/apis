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
        ]);
        $request['user_id'] =(int) auth()->user()->getAuthIdentifier(); 
        
        
        
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
    
    public function show($id = null)
    {
        //show a post 
        $id = (is_null($id))? auth()->user()->id : $id;
        return Post::all()->where('user_id', $id);
    }

    public function wall()
    {
        /*$wall = DB::table('posts')
        ->join('subscriptions', 'subscriptions.added_id', '=', 'posts.user_id')
           ->where('subscriptions.user_id', '=', $id)
        ->where('posts.user_id', 'subscriptions.added_id')->get();  */
        /*
        //show a post 
        
        $wall = DB::select('select * from posts
        Join subscriptions on
        subscriptions.added_id = posts.user_id
        where posts.user_id = subscriptions.added_id and 
        subscriptions.user_id = '. [$id]);
        */
        $wall = DB::select('select * from posts
        Join subscriptions on
        subscriptions.added_id = posts.user_id
        where posts.user_id = subscriptions.added_id and 
        subscriptions.user_id = '.auth()->user()->id.' LIMIT 50');
        

        
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
        $user = auth()->user();
        if($user){
            $post = Post::find($id);
            if(!is_null($post) and $user->id == $post->user_id){
                $post = Post::destroy($id);
                $arr =Post::all();
                $this->centrifugo->publish('posts', ["posts" => $arr]);
                return 'Post deleted';
            }
            else{
                return 'You cant delete someone else`s post';
            }
        }
        
    }
}
