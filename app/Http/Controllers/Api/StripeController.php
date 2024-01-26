<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\StripeData;


class StripeController extends Controller
{
    public function processPayment(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'card_no' => 'required|string',
            'cvc' => 'required|string',
            'expiration_month' => 'required|string',
            'expiration_year' => 'required|string',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => 100,
                'currency' => 'usd',
            ]);
            
            $payment = new StripeData([
                'name' => $request->input('name'),
                'card_no' => $request->input('card_no'),
                'cvc' => $request->input('cvc'),
                'expiration_month' => $request->input('expiration_month'),
                'expiration_year' => $request->input('expiration_year'),
            ]);

            $payment->save();
            return response()->json(['clientSecret' => $payment]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
