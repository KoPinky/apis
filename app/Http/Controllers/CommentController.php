<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use denis660\Centrifugo\Centrifugo;
use Illuminate\Http\Request;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'post_id'=>'required',
            'text'=>'required'
        ]);
        //создание коментария
        $comment = Comment::create($request->all());
        $arr =Comment::all();
        $this->centrifugo->publish('comments', ["comments" => $arr]);
        return $comment;

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
        $comment = Comment::find($id);
        $comment->destroy();
        $arr =Comment::all();
        $this->centrifugo->publish('comments', ["comments" => $arr]);
        return $comment;
    }
}
