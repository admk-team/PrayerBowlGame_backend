<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AddUser;
use App\Models\Notification;
use App\Models\Testimonial;
use App\Models\TopWarrior;
use App\Models\User;
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
            'country' => 'nullable',
            'language' => 'nullable',
            'password' => 'required|confirmed'
        ]);

        $data = User::create($request->only(['name', 'email', 'password', 'country', 'language']));

        if ($data) {
            $token = $data->createToken('MyApp')->plainTextToken;
            $token = explode('|', $token)[1] ?? '';
            $data = [
                'id' => $data->id,
                'name' => $data->name,
                'email' => $data->email,
                'country' => $data->country,
                'language' => $data->language,
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
            'language' => $user->language,
        ];
        return [
            'status' => true,
            'data' => $data,
            'token' => $token
        ];
    }

    public function logout()
    {
        request()->user()->tokens()->where('id', request()->user()->currentAccessToken()->id)->delete();

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

        if ($request->filled('current_password') || $request->filled('password') || $request->filled('password_confirmation')) {
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

        return response()->json(['success' => true, 'message' => 'Profile successfully updated.']);
    }

    public function destroy()
    {
        $user = auth()->user();
        // $addUser = AddUser::where('user_id', $user->id)->get();
        // if ($addUser) {
        //     foreach ($addUser as $useradded) {
        //         $useradded->delete();
        //     }
        // }
        // $notification = Notification::where('user_id', $user->id)->get();
        // if ($notification) {
        //     foreach ($notification as $notiuser) {
        //         $notiuser->delete();
        //     }
        // }
        $user->delete();
        return [
            'message' => 'Account Deleted',
            'status' =>  true,
        ];
    }

    public function setlanguageuser($lang)
    {
        if (auth()->user()) {
            $user = User::findOrFail(auth()->user()->id);
            $user->update(['language' => $lang]);
            return response()->json(['success' => 'Language Updated']);
        } else {
            return response()->json(['error' => 'User Not Logged in']);
        }
    }
}
