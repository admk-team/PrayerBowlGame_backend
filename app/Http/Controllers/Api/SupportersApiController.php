<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Supporters;
use App\Models\TopWarrior;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TopWarriorResource;

class SupportersApiController extends Controller
{
    public function index()
    {
        $supporters = Supporters::orderBy('id', 'DESC')->get();
        return response()->json(['supporters' => $supporters]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country' => 'required',
            'email' => 'required|email',
            'payment_id' => 'required',
            'amount' => 'required|numeric',
            'status' => 'required',
            'date' => 'required|date',
        ]);

        $supporter = Supporters::create($request->all());

        return response()->json(['message' => 'Supporter added successfully', 'supporter' => $supporter], 200);
    }

    public function topwarriors(Request $request)
    {
        $duration = $request->duration;
        $data = TopWarrior::when($duration === 'monthly', function ($q) {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $q->whereBetween('created_at', [$startDate, $endDate]);
        })->when($duration === 'weekly', function ($q) {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
            $q->whereBetween('created_at', [$startDate, $endDate]);
        })->when($duration === 'daily', function ($q) {
            $startDate = Carbon::now()->startOfDay();
            $endDate = Carbon::now()->endOfDay();
            $q->whereBetween('created_at', [$startDate, $endDate]);
        })
            ->orderBy('count', 'desc')->with('user')->take(25)->get();

        return TopWarriorResource::collection($data);
    }
}
