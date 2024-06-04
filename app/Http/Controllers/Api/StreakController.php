<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Streak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StreakController extends Controller
{
    public function updateStreak(Request $request)
    {
        $user = Auth::user();

        $streak = Streak::firstOrCreate(
            ['user_id' => $user->id],
            ['count' => 0, 'last_opened_at' => null]
        );

        $today = Carbon::today();

        if ($streak->last_opened_at) {
            $lastOpened = Carbon::parse($streak->last_opened_at);

            if ($lastOpened->isSameDay($today)) {
                // App was already opened today, do nothing
                return response()->json(['success' => true, 'message' => 'Streak already updated for today.' , 'streak' => $streak]);
            } elseif ($lastOpened->diffInDays($today) > 1) {
                // Missed a day, reset streak
                $streak->count = 1;
            } else {
                // Increment streak
                $streak->count += 1;
            }
        } else {
            // First time opening the app
            $streak->count = 1;
        }

        $streak->last_opened_at = $today;
        $streak->save();

        return response()->json(['success' => true, 'message' => 'Streak updated.', 'streak' => $streak]);
    }
}
