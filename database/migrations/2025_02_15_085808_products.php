<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('img');
            $table->integer('price');
            $table->text('description');
            $table->string('copyright_holder');
            $table->unsignedTinyInteger('rating')->default(null);
            $table->string('type');
            $table->timestamps();
        });
        Schema::create('rg', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); 
        });
 Schema::create('book_rg', function (Blueprint $table) {
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
            $table->foreignId('rg_id')->constrained('rg')->cascadeOnDelete();
            $table->primary(['book_id', 'rg_id']); 
        });

    Schema::create('genres', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique(); 
       
    });
    Schema::create('book_genre', function (Blueprint $table) {
        $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
        $table->foreignId('genre_id')->constrained('genres')->cascadeOnDelete();
        $table->primary(['book_id', 'genre_id']); 
    });
    Schema::create('book_fovor', function (Blueprint $table) {
        $user = Auth::user();
        $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->primary(['book_id', 'user_id']); 
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
        Schema::dropIfExists('book_genre');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('rg');
        Schema::dropIfExists('book_rg');
    }
};
