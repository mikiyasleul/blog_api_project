<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('title');
            $table->longText('detail');
            $table->timestamps();
            $table->softDeletes();

            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::drop('articles');
    }
};
