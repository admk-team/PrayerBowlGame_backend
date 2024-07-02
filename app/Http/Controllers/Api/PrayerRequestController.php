<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prayer;
use App\Models\PrayerRequest;
use App\Models\RequestCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PrayerRequestController extends Controller
{
    public function index()
    {
        $data = RequestCategory::all();
        return response()->json(['req_category' => $data]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'request_type' => 'nullable',
            'message' => 'required',
            'cat_id' => 'required',
        ]);
        $validated['user_id'] = auth()->user()->id;
        $data = PrayerRequest::create($validated);
        if ($data) {
            return response()->json(['success' => true, 'message' => 'Prayer Request Sent successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed']);
        }
    }

    public function myprayer()
    {
        $data = PrayerRequest::where("user_id", auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json(['myprayer' => $data]);
    }
    public function approvedprayer()
    {
        $oneMonthAgo = now()->subMonth();
        $data = PrayerRequest::where('request_type', 'public')->where('status', 'approved')->where('created_at', '>=', $oneMonthAgo)->orderBy('updated_at', 'desc')->get();
        return response()->json(['approvedprayer' => $data]);
    }
    public function prayer($id)
    {

        $prayer = Prayer::where("user_id", auth()->user()->id)->where("req_id", $id)->first();
        if ($prayer) {
            return response()->json(['success' => false, 'message' => 'You are already praying for this person']);
        } else {
            $data = PrayerRequest::with("user")->whereId($id)->first();
            if ($data) {
                if ($data->user->sub_id) {
                    $userIds = [$data->user->sub_id];
                } else {
                    $userIds = [];
                }
                App::setLocale($data->user->language);
                $message = __('Your prayer request has been answered. Someone is praying for you.');
                if (!empty($message) && !empty($userIds)) {
                    $result = $this->onesignal($message, $userIds);
                }
                $data->increment('count');
                $data->save();
                $prayer['user_id']=auth()->user()->id;
                $prayer['req_id']=$id;
                Prayer::create($prayer);
                return response()->json(['success' => true, 'message' => 'Thank you for your prayers. The individual will be informed that you are praying for them.', 'data' => $data]);
            } else {
                return response()->json(['success' => false, 'message' => 'Prayer request not exist']);
            }
        }
    }
}
