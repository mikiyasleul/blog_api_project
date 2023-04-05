<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
        });

    }

    public function down(): void
    {
        Schema::drop('tags');
    }
};
