<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userLibrary1 extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_name', 'image','file_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
