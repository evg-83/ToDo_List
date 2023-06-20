<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todo_tags', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('todo_id');
            $table->unsignedBigInteger('tag_id');

            $table->timestamps();

            // FK
            $table->foreign('todo_id')->on('todos')->references('id')->onDelete('cascade');
            $table->foreign('tag_id')->on('tags')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_tags');
    }
};
