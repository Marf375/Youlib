<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;
use App\Models\rg;
class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'img',
        'price',
        'description',
        'copyright_holder',
        'rating',
        'type',
        'file_path',
        'Year',
        'timer',
    ];
    public function genres(){
        return $this->belongsToMany(Genre::class,'book_genre');
    }
    public function rg(){
        return $this->belongsToMany(rg::class,'book_rg');
    }

}
