<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Http\Controllers\Controller;
use App\Mail\SendContactMessage;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);

        $ContactMessage = ContactMessage::create($validatedData);

        $admindata = User::where('role', '1')->first();
        $admin_email = $admindata->email;

        try {
            Mail::to($admin_email)->send(new SendContactMessage($ContactMessage));
        } catch (\Exception $e) {
        }

        return response()->json([
            'status' => true,
            'message' => 'Message sent successfully',
        ], 200);
    }
}
