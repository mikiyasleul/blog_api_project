<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tag_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');

            $table->index('article_id');
            $table->index('tag_id');
        });
    }

    public function down(): void
    {
        Schema::drop('article_tag');
    }
};
