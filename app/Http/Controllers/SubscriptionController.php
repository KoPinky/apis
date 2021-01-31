<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            
            'added_id' => 'required',
            
        ]);
        //show a post 
        $request['user_id']=auth()->user()->id;
        $subs = Subscription::create($request->all());
        return $subs;
    }
}
