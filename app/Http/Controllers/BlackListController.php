<?php

namespace App\Http\Controllers;

use App\Models\BlackList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class BlackListController
 * @package App\Http\Controllers
 */
class BlackListController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'blocked_id' => 'required',
        ]);

        //show a post
        $request['user_id'] = auth()->user()->id;

        return BlackList::create($request->all());
    }

    /**
     * @param $id
     * @return false|string
     */
    public function check($id)
    {
        //show a post
        $req = BlackList::query()
            ->where('user_id', '=', $id)
            ->where('blocked_id', '=', auth()->user()->id)->get();

        //return is_null($req) ? false : true;
        return json_encode(["result" => ((count($req) > 0) ? "true" : "false")]);
    }
}
