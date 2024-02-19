<?php

// app/Http/Controllers/Api/DonationController.php

namespace App\Http\Controllers\Api;

use Exception;
use Stripe\Price;
use Stripe\Stripe;
use App\Models\User;
use App\Mail\StripEmail;
use App\Models\Donation;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Stripe\Checkout\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Cashier\Console\WebhookCommand;

class DonationController extends Controller
{
    public function donation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'show_supporter_name' => 'required|boolean',
            'donation_amount' => 'required|numeric',
            'donation_type' => 'required|in:one_time,subscription',
            'email' => 'required|string',
            'lookup_key' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if ($request->input('donation_type') === 'one_time') {
            $result = $this->onetimepay($request);
            return $result;
        } elseif ($request->input('donation_type') === 'subscription') {
            return $this->subscription($request);
        }
    }

    public function subscription($request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $current_domain = env('APP_URL');

        try {
            $prices = Price::all([
                // retrieve lookup_key from form data POST body
                'lookup_keys' => [$request->input('lookup_key')],
                'expand' => ['data.product']
            ]);


            // dd($prices->data);

            $checkout_session = Session::create([
                'line_items' => [[
                    'price' => $prices->data[0]->id,
                    'quantity' => 1,
                ]],
                'mode' => 'subscription',
                'success_url' => $current_domain . 'stripepayment?success=true&session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => $current_domain . 'stripepayment?canceled=true',
            ]);

            $donation = new Donation();
            $donation->donation_amount = $request->input('donation_amount');
            $donation->donation_type = $request->input('donation_type');
            $donation->email = $request->input('email');
            // save supporter_name and country based on show_supporter_name
            if ($request->input('show_supporter_name')) {
                $donation->supporter_name = $request->input('supporter_name');
                $donation->country = $request->input('country');
            }

            $donation->save();

            return $checkout_session->url;
            // header("HTTP/1.1 303 See Other");
            // header("Location: " . $checkout_session->url);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function onetimepay($request)
    {

        // Create a customer in Stripe if not exists
        $stripe = new StripeClient(config('services.stripe.secret'));
        // $stripe = new StripeClient(env('STRIPE_SECRET'));


        // Use an existing Customer ID if this is a returning customer.
        $customer = $stripe->customers->create();
        $ephemeralKey = $stripe->ephemeralKeys->create([
            'customer' => $customer->id,
        ], [
            'stripe_version' => '2023-10-16',
        ]);
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $request->input('donation_amount') * 100,
            'currency' => config('cashier.currency'),
            'customer' => $customer->id,
            'payment_method_types' => ['card'],
        ]);

        $donation = new Donation();
        $donation->donation_amount = $request->input('donation_amount');
        $donation->donation_type = $request->input('donation_type');
        $donation->email = $request->input('email');
        // save supporter_name and country based on show_supporter_name
        if ($request->input('show_supporter_name')) {
            $donation->supporter_name = $request->input('supporter_name');
            $donation->country = $request->input('country');
        }

        $donation->save();

        // You may want to store $ephemeralKey->secret in your database for future reference
        $donation->payment_intent_id = $paymentIntent->client_secret;
        $donation->save();

        // Send thank-you email to donor
        $this->sendThankYouEmail($donation);

        return response()->json([
            'donation' => $donation,
            'payment_intent_id' => $paymentIntent->client_secret,
            'ephemeralKey' => $ephemeralKey->secret,
            'customer' => $customer->id,
            'publishableKey' => config('services.stripe.key'),
        ]);
    }

    public function show($id)
    {
        $donation = Donation::findOrFail($id);
        return response()->json([
            'supporter_name' => $donation->supporter_name,
            'country' => $donation->country,
        ]);
    }

    public function sendThankYouEmail($donation)
    {
        // Send email to the donor
        Mail::to($donation->email)->send(new StripEmail($donation));
        // Send email to the super admin
        Mail::to('admin@gmail.com')->send(new StripEmail($donation));
    }

    public function allproducts()
    {
        $stripe = new StripeClient(config('services.stripe.secret'));
        $stripeProducts = $stripe->prices->all([
            'product' => 'prod_PVqAanfceEzbeX',
            'active' => true
        ]);
        return $stripeProducts;
    }
    //Donation details
    public function getDonationDetails(Request $request)
    {
        $donations = Donation::select('supporter_name', 'donation_amount', 'updated_at', 'created_at',)->get();

        return response()->json(['data' => $donations]);
    }
}
