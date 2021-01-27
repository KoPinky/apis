<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
