<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;

class PasswordResetController extends Controller
{
    public function sendOtp(Request $request)
    {
        $rules = [
            'email' => 'required | email | exists:users'
        ];
        $messages = [
            'email.exists' => 'The email is not registered with us.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()], 401);

        $existingOtp = Otp::where('email', $request->email);
        if ($existingOtp != '')
            $existingOtp->delete();

        $code = rand(1000, 9000);
        Otp::create([
            'email' => $request->email,
            'code' => $code
        ]);

        return response()->json([
            'success' => true,
            'message' => 'An OTP code has been sent to your email.',
            'data' => [
                'code' => $code,
            ]
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $rules = [
            'email' => 'required | email | exists:users',
            'code' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $otpEntry = Otp::where('email', $request->email)->first();
                    if ($otpEntry == '' || $otpEntry->code != $request->code)
                        $fail(__('Otp code is expired or invalid.'));
                }
            ]
        ];
        $messages = [
            'email.exists' => 'The email is not registered with us.',
            'code.required' => 'Enter otp code.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()], 401);

        $user = User::where('email', $request->email)->first();
        $token = Password::createToken($user);
        $existingToken = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if ($existingToken) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();
        }

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);
        Otp::where('email', $request->email)->first()->delete();

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token
            ]
        ]);
    }
}
