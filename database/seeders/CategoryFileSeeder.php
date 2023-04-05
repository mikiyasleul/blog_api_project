<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryFileSeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()->count(5)->create();
    }
}
