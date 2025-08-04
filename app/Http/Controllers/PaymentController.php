<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createCustomer()
    {
        $user = User::find(1);
        if(!$user->stripe_id){
            $stripeCustomer = $user->createAsStripeCustomer();
            return response()->json([
                'message'=>'ползователь создан',
                'customer_id'=>$stripeCustomer->id
            ]);
        }
        return response()->json(['message'=>'клиент уже сущестует']);
    }

}
