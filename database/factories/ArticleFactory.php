<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $categories = Category::pluck('id')->toArray();

        return [
            'title' => $this->faker->word,
            'detail' => $this->faker->text(5),
            'category_id' => $this->randomElement($categories),
        ];
    }
}
