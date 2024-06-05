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
        $data=PrayerRequest::create($validated);
        if ($data) {
            return response()->json(['success' => true, 'message' => 'Prayer Request Sent successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed']);
        }
    }

    public function myprayer()
    {
        $data = PrayerRequest::where("user_id" ,auth()->user()->id)->get();
        return response()->json(['myprayer' => $data]);
    }
    public function approvedprayer()
    {
        $data = PrayerRequest::where("request_type" ,"public")->where("status","approved")->get();
        return response()->json(['approvedprayer' => $data]);
    }
    public function prayer($id)
    {
    
        $data = Prayer::where("user_id" ,auth()->user()->id)->where("req_id",$id)->first();
        if($data){
            return response()->json(['success' => false, 'message' => 'You have already prayed']);
        }
        else{
            $data = PrayerRequest::with("user")->whereId($id)->first();
            if($data){
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
            }
            else{
                return response()->json(['success' => false, 'message' => 'Prayer request not exist']);
            }
        }
        return response()->json(['approvedprayer' => $data]);
    }
}
