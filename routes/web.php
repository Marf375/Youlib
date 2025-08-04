<?php
use App\Models\Book;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\catalog;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Revibook;
use Inertia\Inertia;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Storage;
Route::middleware('auth')->post('/orders', [OrderController::class, 'store']);
    Route::get('/',[HomeController::class,'index']);
    Route::get('/books', function () {
        return response()->json(Book::with('genres')->take(20)->get());
    });
    Route::post('/reviews',[Revibook::class,'storeReview']);
    Route::get('/user-library',[OrderController::class, 'getLibrary']);
    Route::get('/user-status',function(){
        if($isAuthenticated = Auth::check()){
            return response()->json(['isAuthenticated'=>true,]);
        }else{
            return response()->json(['isAuthenticated'=>false,]);
        }
    });
Route::get('/payment-success', function () {
    return view('payment-success'); // Покажи успешную оплату
});

Route::get('/payment-cancel', function () {
    return view('payment-cancel'); // Покажи отмену
});
Route::get('/user-st', [StripeController::class, 'getStatus']);
Route::get('/books/{filename}', function ($filename) {
    $path = 'books/' . $filename;

    if (!Storage::disk('s3')->exists($path)) {
        abort(404, 'Файл не найден');
    }

    return response(Storage::disk('s3')->get($path), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . $filename . '"',
    ]);
})->where('filename', '.*')->name('reader');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);
Route::post('/create-checkout-session', [StripeController::class, 'createCheckoutSession']);
Route::get('/reviews',[ReviewController::class,'getReviews']);
Route::Post('/order',[OrderController::class,"store"]);

Route::get('/reviews/book/{bookId}', [Revibook::class, 'getBookReviews']);
Route::get('/book/',[BookController::class,'index'], function () {
    return view('book');
});
Route::get('/genres',[BookController::class,'genres']);
Route::get('/book_a/',[BookController::class,'index1'], function () {
    return view('booka');
});
Route::get('/user/{userId}/name', [Revibook::class, 'getUserName']);
Route::get('/catalog/',[catalog::class,'index'],function () {
    return view('ez');
});
Route::get('/userid',function(){
    return response()->json(Auth::id());
});
Route::get('/user',function(){
    return response()->json(Auth::user());
});


Route::get('/checkout', [StripeController::class, 'checkout'])->name('checkout');
Route::post('/session', [StripeController::class, 'createSession'])->name('session');
Route::get('/success', fn() => 'Оплата прошла успешно!');
Route::get('/cancel', fn() => 'Оплата отменена.');

Route::post('/balance/topup',[ReviewController::class, 'index'])->middleware('auth');
Route::get('/repbalance', [BalanceController::class, 'showForm'])->name('repbalance');
Route::post('/balance/payment', [BalanceController::class, 'handlePayment'])->name('balance.payment');
Route::match(['get', 'post'], '/dashboard', [ReviewController::class, 'index'])->middleware('auth','verified')->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile', [ReviewController::class, 'balanceprf']);
    Route::get('/prifile',[ProfileController::class, 'library']);
});

require __DIR__.'/auth.php';
