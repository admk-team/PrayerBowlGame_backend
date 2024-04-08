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
    public function show($id)
    {
        $data = Notification::where('id', $id)
            ->where('viewed', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json(['show_notification' => $data]);
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

    //user random notification with admin notification
    public function notification()
    {
        // Get the authenticated user's id
        $userId = Auth::id();
        $now = now();
        $admin_notification = Notification::where(function ($query) use ($now) {
            $query->where('start_date', '<=', $now);
        })
            ->where(function ($query) use ($now) {
                $query->where('end_date', '>=', $now);
            })
            ->latest('id') // Order by id in descending order
            ->get();
        $userdetail = User::findOrFail($userId);
        // Retrieve unviewed notifications for the authenticated user
        $user_notification = Notification::where('user_id', $userId)
            ->where('viewed', 0)
            ->get();

        return response()->json(['user_notification' => $user_notification, 'admin_notification' => $admin_notification, 'user_detail' => $userdetail]);
    }

    public function view_notification($id)
    {
        $notifications = Notification::where('user_id', $id)
            ->where('viewed', 0)
            ->get();

        if ($notifications->isNotEmpty()) {
            // Update the viewed field for each notification in the collection
            foreach ($notifications as $notification) {
                $notification->viewed = 1;
                $notification->save();
            }

            // Return a response indicating that the user has viewed notifications
            return response()->json(['message' => 'You have viewed notifications.']);
        } else {
            return response()->json(['message' => 'No unviewed notifications found.']);
        }
    }
}
