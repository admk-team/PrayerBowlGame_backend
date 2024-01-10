<?php

namespace App\Http\Controllers;

use App\Models\AddUser;
use App\Models\RandomUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Mail\PrayerUserMail;
use App\Mail\OtpMail;

class RandomUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = RandomUser::with('user')->latest()->paginate(8);
        return view('admin.random_users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]);

        $user = new RandomUser();
        $user->user_id = $request->user()->id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        if ($user->save()) {
            return response()->json(['success' => true, 'message' => 'Random User data added successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to add user data.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = RandomUser::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully');
    }

    public function get_random_user(Request $request)
    {
        $user = AddUser::where('user_id', $request->user()->id)->inRandomOrder()->first();

        if ($user) {
            RandomUser::create([
                'user_id' => $request->user()->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
            ]);

            Mail::to($user->email)->send(new PrayerUserMail($request->user()->name, $user->first_name . ' ' . $user->last_name));
            return response()->json(['success' => true, 'data' => $user]);
        }

        return response()->json(['success' => false, 'message' => 'Please add names to your list.']);
    }

    public function test()
    {
        // return (new OtpMail('sender', 'reciever'))->render();
        Mail::to('user9585497@gmail.com')->send(new OtpMail('sender', 'reciever'));
        return 'email sent';
    }
}