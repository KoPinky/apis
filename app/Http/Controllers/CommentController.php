<?php

namespace App\Http\Controllers;

use App\Models\BlackList;
use App\Models\Comment;
use App\Models\Post;
use denis660\Centrifugo\Centrifugo;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $centrifugo;

    /**
     * CommentController constructor.
     * @param Centrifugo $centrifugo
     */
    public function __construct(Centrifugo $centrifugo)
    {
        $this->centrifugo = $centrifugo;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
            'text' => 'required'
        ]);
        $post = Post::find($request['post_id']);
        $req = BlackList::query()
            ->where('user_id', $post['user_id'])
            ->where('blocked_id', auth()->user()->id)->exists();
        if ($req) {
            //создание коментарий
            $request['user_id'] = auth()->user()->id;
            $comment = Comment::create($request->all());
            $arr = Comment::all();
            $this->centrifugo->publish('comments', ["comments" => $arr]);
            return response()->json($comment);
        } else {
            return response()->json('you cannot leave a comment');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //удаление коментария
        $user = auth()->user();
        if ($user) {
            $comment = Comment::find($id);
            if (!is_null($comment) and $user->id == $comment->user_id) {
                $post = Comment::destroy($id);
                $arr = Comment::orderBy('id', 'desc')->take(50)->get();
                $this->centrifugo->publish('comments', ["comments" => $arr]);
                return response()->json('Comment deleted');
            } else {
                return response()->json('You cant delete someone else`s comment');
            }
        }
    }
}
