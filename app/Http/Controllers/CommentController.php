<?php

namespace App\Http\Controllers;

use App\Models\BlackList;
use App\Models\Comment;
use App\Models\Post;
use denis660\Centrifugo\Centrifugo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{

    public function __construct(Centrifugo $centrifugo)
    {
        $this->centrifugo = $centrifugo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //закрыто на ТО, так как не нуда

     public function index($id)
    {
        return Comment::all()->where('post_id', $id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id'=>'required',
            'text'=>'required'
        ]);
        $post = Post::Find($request['post_id']);
        $req = BlackList::all()
        ->where('user_id', $post['user_id'])
        ->where('blocked_id', auth()->user()->id);
        return var_dump($req->count);
        if (is_null($req))
        { 
            //создание коментарий
            $request['user_id']= auth()->user()->id;
            $comment = Comment::create($request->all());
            $arr =Comment::all();
            $this->centrifugo->publish('comments', ["comments" => $arr]);
            return $comment;
        }
        else{
            return 'you cannot leave a comment';
        }
        

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //удаление коментария
        $user = auth()->user();
        if($user){
            $comment = Comment::find($id);
            if(!is_null($comment) and $user->id == $comment->user_id){
                $post = Comment::destroy($id);
                $arr =Comment::all();
                $this->centrifugo->publish('comments', ["comments" => $arr]);
                return 'Comment deleted';
            }
            else{
                return 'You cant delete someone else`s comment';
            }
        }
    }
}
