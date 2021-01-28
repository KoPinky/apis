<?php

namespace App\Http\Controllers;

use App\Models\BlackList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlackListController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'blocked_id' => 'required',
            
        ]);
        //show a post 
        $post = BlackList::create($request->all());
        return $post;
    }

    public function check(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'blocked_id' => 'required',
            
        ]);
        //show a post 
        $req =DB::table('black_lists')
        ->where('user_id', '=', $request->input('user_id'))
        ->where('blocked_id', '=', $request->input('blocked_id'))->get();
        //return is_null($req) ? false : true;
        return json_encode(["result" => ((count($req)>0)?"true":"false")]);
    }
}
