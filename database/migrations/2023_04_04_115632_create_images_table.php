<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('image_url');
            $table->morphs('parentable');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('images');
    }
};
