<?php

namespace Database\Seeders;

use App\Models\BlackList;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
        ->count(50)
        ->create();
        Post::factory()
        ->count(50)
        ->create();
        Subscription::factory()
        ->count(50)
        ->create();
        BlackList::factory()
        ->count(50)
        ->create();
        Comment::factory()
        ->count(50)
        ->create();
    }
}
