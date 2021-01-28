<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'added_id' => 'required',
            
        ]);
        //show a post 
        $subs = Subscription::create($request->all());
        return $subs;
    }
}
