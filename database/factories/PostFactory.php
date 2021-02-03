<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Support\Str;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;


class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'theme' => $this->faker->name,
            'text' => $this->faker->text(),
            'user_id' => rand(1, 50), 
        ];
    }
}
