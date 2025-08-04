<?php
namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller{
    public function index()
    {
        $isAuthenticated=Auth::check();
        $userLibrary=$isAuthenticated ? Auth::user()->library:[];
        $books = Book::latest()->limit(15)->get(); 
        $boo=Book::with('genres')->get();
        return view('index', compact('books','isAuthenticated','userLibrary','boo'));
    
}

}

   

    
