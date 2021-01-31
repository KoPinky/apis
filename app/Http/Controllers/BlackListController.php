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
            'blocked_id' => 'required',
        ]);
        //show a post 
        $request['user_id']= auth()->user()->id;
        $blackList = BlackList::create($request->all());
        return $blackList;
    }

    public function check($id)
    {
        
        //show a post 
        $req =DB::table('black_lists')
        ->where('user_id', '=', $id)
        ->where('blocked_id', '=', auth()->user()->id)->get();
        //return is_null($req) ? false : true;
        return json_encode(["result" => ((count($req)>0)?"true":"false")]);
    }
}
