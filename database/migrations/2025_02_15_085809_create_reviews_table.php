<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Book;
return new class extends Migration {
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $user = Auth::user();
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('content');
            $table->unsignedTinyInteger('rating')->default(0);
            $table->timestamps();
            
        });
        Schema::create('book_reviews', function (Blueprint $table) {
            $table->foreignId('reviews_id')->constrained('reviews')->cascadeOnDelete();
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
           
            $table->primary(['reviews_id','book_id' ]); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('book_reviews');
    }
};