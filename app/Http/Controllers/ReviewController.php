<?php
namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\User;
use App\Models\Genre;

class ReviewController extends Controller
{

    public function guestHome()
    {
        $reviews = Review::latest()->paginate(5);
        return view('index', compact('reviews'));
    }

   
    
 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $review = Review::create([
            'user_id' => auth()->id(), // Текущий авторизованный пользователь
            'content' => $validated['content'],
            'rating' => $validated['rating']
       
        ]);

        return response()->json($review, 201);
    }
  
    public function index(Request $request)
    {
        // Получаем книги и статус авторизации
        $isAuthenticated = Auth::check();
        $userLibrary = $isAuthenticated ? Auth::user()->library : [];
        $books = Book::latest()->limit(15)->get();
        $boo = Book::with('genres')->get();

        // Если есть POST-запрос на пополнение баланса
        if ($request->isMethod('post')) {
            $request->validate([
                'amount' => 'required|numeric|min:1'
            ]);

            $user = Auth::user();
            $user->balance += $request->amount;
            $user->save();

            return redirect()->route('dashboard')->with('success', 'Баланс успешно пополнен');
        }

        return view('dashboard', compact('books', 'isAuthenticated', 'userLibrary', 'boo'));
    }
     }
 

    //  public function balanceprf()
    //  {
    //     $user = Auth::user();
    //     $balance = $user && method_exists($user, 'balance') ? $user->balance() : ' ';
         
       
    //      return view('edit', compact('balance'));
    //  }
 







  