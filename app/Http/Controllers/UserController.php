<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function showProfile($id = null)
    {
        $id = (is_null($id)) ? (int)auth()->user()->getAuthIdentifier() : $id;

        return response(Redis::get('user_profile_' . $id))->header('Content-Type', 'application/json');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $user = User::find((int)auth()->user()->id);
        $user->update($request->all());
        $this->refresh_redis_profile($user->id);
        return response()->json($user);
    }
}
