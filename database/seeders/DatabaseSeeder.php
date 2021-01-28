<?php

namespace Database\Seeders;

use App\Models\BlackList;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\User;
use Database\Factories\UserFactory;
use Faker\Factory;
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
        ->count(300)
        ->create();
        Post::factory()
        ->count(300)
        ->create();
        Subscription::factory()
        ->count(300)
        ->create();
        BlackList::factory()
        ->count(300)
        ->create();
        Comment::factory()
        ->count(300)
        ->create();
    }
}
