<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagFileSeeder extends Seeder
{
    public function run(): void
    {
        Tag::factory()->count(10)->create();         
    }
}
