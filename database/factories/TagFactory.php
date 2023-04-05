<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        $users = User::pluck('id')->toArray();

        return [
            'name' => $this->faker->name,
            'user_id' => $this->randomElement($users),
        ];
    }
}
