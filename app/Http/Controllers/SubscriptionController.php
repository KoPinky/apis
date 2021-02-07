<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'added_id' => 'required',
        ]);

        //show a post
        $request['user_id']=auth()->user()->id;
        return Subscription::create($request->all());
    }
}
