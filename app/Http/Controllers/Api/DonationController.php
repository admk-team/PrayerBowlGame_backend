<?php

// app/Http/Controllers/Api/DonationController.php

namespace App\Http\Controllers\Api;

use App\Helpers\TranslateTextHelper;
use Exception;
use Stripe\Price;
use Carbon\Carbon;
use Stripe\Stripe;
use App\Models\User;
use App\Mail\StripEmail;
use App\Models\Donation;
use Stripe\StripeClient;
use Stripe\Subscription;
use App\Mail\DonationEmail;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Stripe\Checkout\Session;
use App\Mail\AdminDonationEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Models\EmailSetting;
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
            'email' => 'nullable|string',
            'lookup_key' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if ($request->input('donation_type') === 'one_time') {
            $result = $this->onetimepay($request);

            return $result;
        } elseif ($request->input('donation_type') === 'subscription') {
            $result = $this->subscription($request);
            return $result;
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
                'success_url' => $current_domain . '/stripepayment?success=true&session_id={CHECKOUT_SESSION_ID}' . '&user_id=' . auth()->user()->id . '&plan=' . $request->input('lookup_key'),
                'cancel_url' => $current_domain . '/stripepayment?canceled=true',
            ]);

            $donation = new Donation();
            $donation->donation_amount = $request->input('donation_amount');
            $donation->donation_type = $request->input('donation_type');
            $donation->email = $request->input('email');
            $donation->user_id = auth()->user()->id;
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
        $donation->user_id = auth()->user()->id;
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

        return response()->json([
            'donation' => $donation,
            'payment_intent_id' => $paymentIntent->client_secret,
            'ephemeralKey' => $ephemeralKey->secret,
            'customer' => $customer->id,
            'publishableKey' => config('services.stripe.key'),
        ]);
    }



    public function sendThankYouEmail($id)
    {
        $doner_data = Donation::findOrFail($id);
        $doner_email = $doner_data['email'];
        $admindata = User::where('role', '1')->first();
        $admin_email = $admindata->email;
        try {
            $userPersonalData = User::where('email', $doner_email)->first();
            if ($userPersonalData) {
                App::setLocale($userPersonalData->language ? $userPersonalData->language : 'en');
                $emailSettings = EmailSetting::first();
                if (!empty($emailSettings->message)) {
                    TranslateTextHelper::setSource('en')->setTarget($userPersonalData->language);
                    $footertext = TranslateTextHelper::translate($emailSettings->message);
                }
            }
            Mail::to($doner_email)->send(new DonationEmail($doner_data ?? null, $doner_data->donation_amount  ?? null
            ,$footertext ?? null));
        } catch (\Exception $e) {
        }
        try {
            $test2 =  Mail::to($admin_email)->send(new AdminDonationEmail($admindata ?? null, $doner_data ?? null, $doner_data->donation_amount ?? null));
        } catch (\Exception $e) {
        }

        return response()->json(['success' => 'true']);
    }

    public function allproducts()
    {
        $stripe = new StripeClient(config('services.stripe.secret'));
        $stripeProducts = $stripe->prices->all([
            'product' => 'prod_PydjM8h5sRAXMw',
            'active' => true,
            'limit' => 50,
        ]);
        return $stripeProducts;
    }
    // Donation details
    public function getDonationDetails(Request $request)
    {
        $donations = Donation::where('supporter_name', '<>', '') // Exclude empty strings as well
            ->orderBy('created_at', 'desc')
            ->get(['supporter_name', 'donation_amount', 'updated_at', 'created_at']);

        return response()->json(['data' => $donations]);
    }


    public function index()
    {
        $supporters = Donation::orderBy('id', 'DESC')->paginate(10);
        return view('admin.donations.index', compact('supporters'));
    }
    public function show($id)
    {
        $supporter = Donation::findOrFail($id);
        return response()->json(['data' => $supporter]);
    }


    public function success(Request $request)
    {

        $stripe = new StripeClient(config('services.stripe.secret'));
        $data = $stripe->checkout->sessions->retrieve(
            $request->session_id,
            []
        );

        DB::table('subscriptions')->insert([
            'user_id' => $request->user_id,
            'type' => $request->plan,
            'quantity' => 1,
            'stripe_id' => $data->subscription,
            'stripe_status' => $data->status,
            'stripe_price' => $data->amount_total,
            'trial_ends_at' => Carbon::parse($data->expires_at),
            'ends_at' => Carbon::parse($data->expires_at),
        ]);

        //getting amount for emal
        // $amount = $request->input('donation_amount');

        // Get the authenticated user's id
        // $doner = Auth::id();
        // $doner_data = User::where('id', $doner)->first();
        // $doner_email = $doner_data['email'];

        $donarData = Donation::where('user_id', $request->user_id)->orderBy('created_at', 'DESC')->first();
        $userPersonalData = User::findOrFail($request->user_id);

        $admindata = User::where('role', '1')->first();
        $admin_email = $admindata->email;
        try {
            if ($userPersonalData) {
                App::setLocale($userPersonalData->language ? $userPersonalData->language : 'en');
                $emailSettings = EmailSetting::first();
                if (!empty($emailSettings->message)) {
                    TranslateTextHelper::setSource('en')->setTarget($userPersonalData->language);
                    $footertext = TranslateTextHelper::translate($emailSettings->message);
                }
            }
            Mail::to($donarData->email)->send(new DonationEmail($donarData ?? null, $donarData->donation_amount ?? null, $footertext ?? null));
        } catch (\Exception $e) {
        }
        try {
            Mail::to($admin_email)->send(new AdminDonationEmail($admindata ?? null, $donarData ?? null, $donarData->donation_amount ?? null));
        } catch (\Exception $e) {
        }
        return view('payment.success');
    }

    public function canclesubuser($id)
    {
        $user_data = DB::table('subscriptions')->whereId($id)->where('stripe_status', 'complete')->first();
        if ($user_data) {
            $canclestripe = new StripeClient(config('services.stripe.secret'));
            try {

                $stripecancle = $canclestripe->subscriptions->cancel(
                    $user_data->stripe_id,
                    []
                );
                DB::table('subscriptions')->whereId($id)->where('stripe_status', 'complete')->update(['stripe_status' => 'canceled']);
                return response()->json(['success' => 'Subscription canceled Successfully']);
            } catch (Exception $e) {
                DB::table('subscriptions')->whereId($id)->where('stripe_status', 'complete')->update(['stripe_status' => 'canceled']);
                return response()->json(['error' => $e->getMessage()]);
            };
        } else {
            return response()->json(['error' => 'Subscription canceled Already']);
        }
    }

    public function getsubscriptiondata()
    {
        $data = DB::table('subscriptions')->where('user_id', auth()->user()->id)->where('stripe_status', 'complete')->orderBy('updated_at', 'DESC')->get();
        return response()->json(['data' => $data]);
    }
}
