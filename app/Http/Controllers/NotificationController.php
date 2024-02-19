<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Notification::whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->get();
        return view('admin.notification.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.notification.createoredit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules can be adjusted based on your requirements
        $validatedData = $request->validate([
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Notification::create($validatedData);

        return redirect()->route('notification.index')->with('success', 'Notification created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Notification::findorFail($id);
        return view('admin.notification.createoredit', compact('data'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation rules can be adjusted based on your requirements
        $validatedData = $request->validate([
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        $notification = Notification::findorFail($id);
        $notification->update($validatedData);

        return redirect()->route('notification.index')->with('success', 'Notification updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $notification = Notification::findorFail($id);
        $notification->delete();
        return redirect()->route('notification.index')->with('success', 'Banner deleted successfully!');
    }
    //admin notification 
    public function notification()
    {
        $now = now();
        $data = Notification::where(function ($query) use ($now) {
            $query->where('start_date', '<=', $now);
        })
            ->where(function ($query) use ($now) {
                $query->where('end_date', '>=', $now);
            })
            ->get();
        return response()->json(['data' => $data]);
    }
    //user random notification 
    public function random_notification()
    {
        // Get the authenticated user's id
        $userId = Auth::id();

        $userdetail = User::findOrFail($userId);
        // Retrieve unviewed notifications for the authenticated user
        $data = Notification::where('user_id', $userId)
            ->where('viewed', 0)
            ->get();
        return response()->json(['data' => $data, 'user_detail' => $userdetail]);
    }
    //when user viewed 
    public function view_notification(Request $request)
    {
        $userId = Auth::id();
        // Retrieve the unviewed notification for the authenticated user
        $notification = Notification::where('user_id', $userId)
            ->where('viewed', 0)
            ->first();  // Use first() to get a single model instance
        if ($notification) {
            // Update the viewed field to 1
            $notification->viewed = 1;
            $notification->save();
            // Return both notification and user detail separately
            return response()->json(['message' => 'Yoh have viewed notifications.']);
        } else {
            return response()->json(['message' => 'No unviewed notifications found.']);
        }
    }
}
