<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;
class StripeController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $items = $request->input('items', []);
        $metadata = $request->input('metadata', []);

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => array_map(function ($item) {
                    return [
                        'price_data' => [
                            'currency' => 'rub',
                            'product_data' => [
                                'name' => $item['name'],
                            ],
                            'unit_amount' => $item['price'], // в копейках (например, 39900 = 399 руб.)
                        ],
                        'quantity' => $item['quantity'],
                    ];
                }, $items),
                'mode' => 'payment',
                'success_url' => url('/payment-success'),
                'cancel_url' => url('/payment-cancel'),
                'metadata' => $metadata, // 🎯 Передаём user_id и cart
            ]);

            return response()->json(['url' => $session->url]);
        } catch (\Exception $e) {
            \Log::error('Ошибка Stripe: ' . $e->getMessage());
            return response()->json(['error' => 'Ошибка при создании сессии Stripe'], 500);
        }
    }
    public function getStatus()
    {
        $user = Auth::user();
        return response()->json([
            'isAuthenticated' => $user !== null,
            'id' => $user?->id,
            'name' => $user?->name,
            'email' => $user?->email,
            'balance' => $user?->balance,
        ]);
    }
}


