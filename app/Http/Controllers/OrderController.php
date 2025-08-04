<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'cart.*.bookName' => 'required|string',
            'cart.*.bookPrice' => 'required|numeric',
            'cart.*.img' => 'required|string',
            'total' => 'required|numeric',
        ]);

        $user = Auth::user();

        if ($user->balance < $request->total) {
            return response()->json(['success' => false, 'error' => 'Недостаточно средств'], 400);
        }

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $request->total,
        ]);

        foreach ($request->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_name' => $item['bookName'],
                'book_price' => $item['bookPrice'],
                'image' => $item['img'],
            ]);

            UserLibrary::updateOrCreate(
                ['user_id' => $user->id, 'book_name' => $item['bookName']],
                ['image' => $item['img'], 'file_path' => $item['file_path']]  // Все атрибуты в одном массиве
            );
        }

        // Списание баланса
        $user->decrement('balance', $request->total);

        return response()->json(['success' => true]);
    }


public function getLibrary()
{
$user = Auth::user();
$library = UserLibrary::where('user_id', $user->id)->get();
return response()->json(['library' => $library]);
}
}
