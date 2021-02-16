<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;

use http\Env\Response;
use Illuminate\Http\Request;
use denis660\Centrifugo\Centrifugo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{

    private $centrifugo;

    /**
     * Class __construct
     *
     * @param Centrifugo $centrifugo
     */
    public function __construct(Centrifugo $centrifugo)
    {
        $this->centrifugo = $centrifugo;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //validate
        $request->validate([
            'theme' => 'required',
            'text' => 'required',
        ]);
        $request['user_id'] = (int)auth()->user()->getAuthIdentifier();

        //create a post
        $post = Post::create($request->all());

        //set in Redis
        $this->refresh_redis_posts($request['user_id']);

        //publish to centrifugo
        $arr = Post::orderBy('id', 'desc')->take(100)->get();;
        $this->centrifugo->publish('posts', ["posts" => $arr]);
        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        //standart way
        /*
        //show a post
        $id = (is_null($id))? auth()->user()->id : $id;
        return Post::all()->where('user_id', $id);
        */
        $id = (is_null($id)) ? auth()->user()->id : $id;
        return response(Redis::get('user_posts_' . $id))->header('Content-Type', 'application/json');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function wall()
    {
        $wall = Post::query()
            ->join('subscriptions', 'subscriptions.added_id', '=', 'posts.user_id')
            ->where('posts.user_id', '=', 'subscriptions.added_id')
            ->where('subscriptions.user_id', '=', auth()->user()->id)
            ->limit(50)
            ->get();

        return response()->json($wall);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //delete a post
        $user = auth()->user();
        if ($user) {
            $post = Post::find($id);
            if (!is_null($post) and $user->id == $post->user_id) {
                $post = Post::destroy($id);
                $arr = Post::all();
                $this->centrifugo->publish('posts', ["posts" => $arr]);
                $this->refresh_redis_posts($user->id);
                return response()->json('Post deleted');
            }
            return response()->json('You cant delete someone else`s post');

        }
    }
}
