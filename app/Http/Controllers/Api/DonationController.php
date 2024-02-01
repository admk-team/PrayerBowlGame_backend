<?php

// app/Http/Controllers/Api/DonationController.php

namespace App\Http\Controllers\Api;

use App\Mail\StripEmail;
use App\Models\User;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_number' => 'required|numeric',
            'name_on_card' => 'required|string',
            'expiry_date' => 'required|string',
            'cvv' => 'required|numeric',
            'show_supporter_name' => 'required|boolean',
            'donation_amount' => 'required|numeric',
            'donation_type' => 'required|in:one_time,weekly,monthly,annually',
            'email' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $donation = new Donation();
        $donation->card_number = $request->input('card_number');
        $donation->name_on_card = $request->input('name_on_card');
        $donation->expiry_date = $request->input('expiry_date');
        $donation->cvv = $request->input('cvv');
        $donation->donation_amount = $request->input('donation_amount');
        $donation->donation_type = $request->input('donation_type');
        $donation->email = $request->input('email');
        // save supporter_name and country based on show_supporter_name
        if ($request->input('show_supporter_name')) {
            $donation->supporter_name = $request->input('supporter_name');
            $donation->country = $request->input('country');
        }

        $donation->save();

        // Send thank-you email to donor
        $this->sendThankYouEmail($donation);

        return response()->json($donation);
        // return response()->json(['message' => 'Donation data received and saved successfully']);
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
}
