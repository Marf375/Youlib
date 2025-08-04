<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class BalanceController extends Controller
{
    public function showForm()
    {
        return view('repbalance');
    }

    public function handlePayment(Request $request)
    {
        $user = auth()->user();
        $amount = (int)($request->input('amount')); // рубли в копейки

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'rub',
                'metadata' => [
                    'user_id' => $user->id,
                ],
                'automatic_payment_methods' => ['enabled' => true],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
