<?php

namespace App\Http\Controllers;

use App\Models\AddUser;
use App\Models\RandomUser;
use Illuminate\Http\Request;

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
        // Find the user by ID and delete
        $user = RandomUser::findOrFail($id);
        $user->delete();

        // You may redirect to a different page or return a response as needed
        return redirect()->back()->with('success', 'User deleted successfully');
    }
}
