<?php

namespace App\Http\Controllers;

use App\Models\AddUser;
use App\Models\User;
use App\Models\RandomUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddedUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = AddUser::with('user')->orderBy('id','asc')->paginate(8);
        return view('admin.added_users.index', compact('users'));
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
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
        ];
        if ($request->filled('email'))
            $rules['email'] = 'email';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json(['success' => false, 'errors' => $validator->errors()]);

        $user = new AddUser();
        $user->user_id = $request->user()->id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->registered_user = $request->user()->name;

        if ($user->save()) {
            return response()->json(['success' => true, 'message' => 'User data added successfully.']);
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
        $user = AddUser::find($id) ?? '';
        return response()->json(['success' => true, 'data' => $user]);
    }

    /**
     * Update the specified resource in storage. 
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
        ];
        if ($request->filled('email'))
            $rules['email'] = 'email';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json(['success' => false, 'errors' => $validator->errors()]);

        $user = AddUser::find($id);
        if ($user == '')
            return response()->json(['success' => false, 'errors' => ['id' => ['User not found.']]]);

        $user->update($request->all());
        return response()->json(['success' => true, 'message' => 'User successfully updated.', 'data' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the user by ID and delete
        $user = AddUser::findOrFail($id);
        $user->delete();

        // You may redirect to a different page or return a response as needed
        return redirect()->back()->with('success', 'User deleted successfully');
    }

    public function get_users(Request $request)
    {
        $user = AddUser::where('user_id', $request->user()->id)->get();
        return response()->json(['success' => true, 'data' => $user]);
    }

    public function get_user_details(Request $request, $id)
    {
        $user = AddUser::find($id);
        $random_users = RandomUser::where('user_id', $request->user()->id)->where(function ($query) use ($user) {
            if ($user->email !== null) {
                $query->where('email', $user->email);
            }
            else {
                $query->where('first_name', $user->first_name)
                    ->where('last_name', $user->last_name);
            }
        })->get();

        $dates = $random_users->map(function ($random_user) {
            return \Carbon\Carbon::parse($random_user->created_at)->format('d-m-Y H:i');
        });

        return response()->json(['success' => true, 'data' => ['user' => $user, 'dates' => $dates]]);
    }

    public function delete_user(Request $request, $id)
    {
        AddUser::findOrFail($id)->delete();

        $users = AddUser::where('user_id', $request->user()->id)->get();

        return response()->json(['success' => true, 'data' => $users, 'message' => 'User deleted successfully.']);
    }
}
