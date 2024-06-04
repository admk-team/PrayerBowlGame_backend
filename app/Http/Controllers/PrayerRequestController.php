<?php

namespace App\Http\Controllers;

use App\Models\PrayerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PrayerRequestController extends Controller
{
    public function index()
    {
        $data = PrayerRequest::with('requestcategory', 'user')->get();
        return view('admin.prayrequest.index', compact('data'));
    }
    public function show($id)
    {
        $prayrequest = PrayerRequest::with(['user', 'requestcategory'])->findOrFail($id);
        return response()->json(['data' => $prayrequest]);
    }
    public function destroy($id)
    {
        $data = PrayerRequest::findOrFail($id);
        $data->delete();
        return back()->with('success', 'Prayer Request deleted successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate the status input
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);
    
        // Find the PrayerRequest by ID
        $pray = PrayerRequest::findOrFail($id);
        
        // Update the status based on the request
        $pray->status = $request->status;
        $pray->save();
        $checkuser = User::where('id', $pray->user_id)->first();
            if ($checkuser->sub_id) {
                $userIds = [$checkuser->sub_id];
            } else {
                $userIds = [];
            }
            App::setLocale($checkuser->language);
            if($pray->status =="approved"){
                $message = __('Your Prayer Request has been approved');
            }
            if($pray->status =="rejected"){
                $message = __('Your Prayer Request has been rejected');
            }
            if (!empty($message) && !empty($userIds)) {
                $result = $this->onesignal($message, $userIds);
            }
        // Return a response indicating success
        return response()->json(['success' => true, 'message' => 'Prayer Request status updated successfully.']);
    }
}
