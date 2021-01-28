<?php

namespace Database\Factories;

use App\Models\BlackList;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlackListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlackList::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=>rand(0,50),
            'blocked_id'=>rand(0, 50),
        ];
    }
}
