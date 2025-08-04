<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class catalog extends Controller
{
    public function index()
    {
        $books_arr = Book::latest()->paginate(15);
        $books = Book::inRandomOrder()->limit(15)->get(); // 15 случайных книг
        return view('ez', compact('books_arr'));
}
}
