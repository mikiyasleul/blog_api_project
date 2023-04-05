<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Mikiyas Leul',
            'email' => 'mikiyas@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);

        $this->call(CategoryFileSeeder::class);
        $this->call(ArticleFileSeeder::class);
        $this->call(TagFileSeeder::class);
    }
}
