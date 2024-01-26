<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class DonationController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string',
            'name_on_card' => 'required|string',
            'expiry_date' => 'required|string',
            'cvv' => 'required|string',
            'supporter_name' => 'required|string',
            'country' => 'required|string',
            'donation_amount' => 'required|numeric',
            'donation_type' => 'required|string',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => 100,
                'currency' => 'usd',
            ]);

            $Donation = new Donation([
                'card_number' => $request->input('card_number'),
                'name_on_card' => $request->input('name_on_card'),
                'expiry_date' => $request->input('expiry_date'),
                'cvv' => $request->input('cvv'),
                'supporter_name' => $request->input('supporter_name'),
                'country' => $request->input('country'),
                'donation_amount' => $request->input('donation_amount'),
                'donation_type' => $request->input('donation_type'),
            ]);

            $Donation->save();
            return response()->json(['message' => $Donation]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
