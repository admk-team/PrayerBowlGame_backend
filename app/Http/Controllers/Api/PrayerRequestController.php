<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PrayerRequest;
use App\Models\RequestCategory;
use Illuminate\Http\Request;

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
}
