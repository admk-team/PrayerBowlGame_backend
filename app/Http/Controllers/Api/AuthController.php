<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        $data = User::create($request->only(['name', 'email', 'password']));

        if ($data) {
            $token = $data->createToken('MyApp')->plainTextToken;
            $token = explode('|', $token)[1] ?? '';
            $data = [
                'id' => $data->id,
                'name' => $data->name,
                'email' => $data->email,
            ];
            return response()->json(['success' => true, 'token' => $token, 'data' => $data]);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to register']);
        }
    }
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }


        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'These credentials do not match our records.',
                'errors' => [
                    'email' => [
                        'These credentials do not match our records.'
                    ]
                ]
            ], 422);
        }
        $token = $user->createToken('login')->plainTextToken;
        $token = explode('|', $token)[1] ?? '';
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
        return [
            'status' => true,
            'data' => $data,
            'token' => $token
        ];
    }

    public function logout()
    {
        request()->user()->tokens()->delete();

        return [
            'status' => true,
        ];
    }

    public function profile_update(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'confirmed';
            $rules['password_confirmation'] = 'required';
            $rules['current_password'] = [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!\Hash::check($value, $user->password)) {
                        $fail(__('The current password is incorrect.'));
                    }
                },
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $user->update([
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'email' => $request->input('email'),
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => bcrypt($request->input('password')),
            ]);
        }
    }
}
