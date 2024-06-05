<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReminderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderNotificationController extends Controller
{
    public function index()
    {
        $reminder = ReminderNotification::where('user_id', Auth::id())->get();
        return response()->json(['reminder' => $reminder]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'start_datetime' => 'required',
            'duration' => 'required',
        ]);
        $validated['user_id'] = Auth::id();
        $reminder=ReminderNotification::where('user_id',Auth::id())->first();
        if($reminder){
            $reminder->update($validated);
        }else{
            $reminder=ReminderNotification::create($validated);
        }
        if ($reminder) {
            return response()->json(['success' => true, 'reminder' => $reminder]);
        }else {
            return response()->json(['success' => false, 'message' => 'Failed']);
        }
    }

    public function show($id)
    {
        $reminder = ReminderNotification::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($reminder);
    }

    public function update(Request $request, $id)
    {
        $validated=$request->validate([
            'type' => 'required',
            'start_datetime' => 'required',
            'duration' => 'required',
        ]);

        $reminder = ReminderNotification::where('user_id', Auth::id())->findOrFail($id);
        $reminder->update($validated);

        return response()->json(['success' => true, 'reminder' => $reminder]);
    }

    public function destroy($id)
    {
        $reminder = ReminderNotification::where('user_id', Auth::id())->findOrFail($id);
        $reminder->delete();

        return response()->json(['success' => true, 'message' => 'Reminder deleted successfully.']);
    }
}
