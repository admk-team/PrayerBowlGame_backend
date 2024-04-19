<?php

namespace App\Http\Controllers\Api;

use App\Models\Otp;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

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

        $user = User::where('email', $request->email)->first();
        $codeStr = (string) $code;
        $codeArr = str_split($codeStr);
        $formattedCode = '';

        foreach ($codeArr as $key => $value) {
            $formattedCode .= $value;
            if ($key != (sizeof($codeArr) - 1))
                $formattedCode .= ' ';
        }
        App::setLocale($user->language);
        Mail::to($request->email)->send(new OtpMail($user->name, $formattedCode));

        return response()->json([
            'success' => true,
            'message' => 'An OTP code has been sent to your email.',
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
                        $fail(__('Otp code is either invalid or expired.'));
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
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        $rules = [
            'token' => 'required | exists:password_reset_tokens',
            'password' => 'required | confirmed',
            'password_confirmation' => 'required'
        ];
        $messages = [
            'token.exists' => 'Invalid authentication token.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password_confirmation.required' => 'Please confirm your password.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->errors()], 401);

        $tokenData = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first();

        $user = User::where('email', $tokenData->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->delete();
        return response()->json(['success' => true, 'message' => 'Password successfully updated.'], 200);
    }
}
