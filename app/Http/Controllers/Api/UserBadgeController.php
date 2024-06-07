<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\UserBadge;
use Illuminate\Http\Request;

class UserBadgeController extends Controller
{
    public function index()
    {
        $data = Badge::all();
        if ($data) {
            return response()->json([
                'status' => true,
                'all_badges' => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Not data found",
            ], 200);
        }
    }
    public function userBadge()
    {
        $data = UserBadge::where("user_id", auth()->user()->id)->with("badge")->get();
        if ($data) {
            return response()->json([
                'status' => true,
                'user_badges' => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Not data found",
            ], 200);
        }
    }
    public function badgeDetail($id)
    {
        $data = UserBadge::where("user_id", auth()->user()->id)->where("badge_id", $id)->with("badge")->first();
        if ($data) {
            return response()->json([
                'status' => true,
                'badge_details' => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Not data found",
            ], 200);
        }
    }
}
