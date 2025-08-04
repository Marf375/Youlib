<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;
use Smalot\PdfParser\Parser;
class BookController extends Controller
{
    public function index()
    {
        $books_arr = Book::all();

        $books = Book::inRandomOrder()->limit(15)->get();
        return view('book', compact('books_arr'));
}
public function index1()
{
    $books_arr = Book::all();
    $books = Book::inRandomOrder()->limit(15)->get();
    return view('booka', compact('books_arr'));
}
public function genres(){
    $genres=Genre::all();
    return $genres;
}
        public function showTextBook($filename)
    {
        return view('reader', compact('filename'));
    }
}
