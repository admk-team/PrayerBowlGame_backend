<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopWarriorResource;
use Illuminate\Http\Request;
use App\Models\Supporters;
use App\Models\TopWarrior;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

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
        $time = $request->duration;
        
        $data = TopWarrior::when($time === 'monthly', function ($q) {
            $from = Carbon::now()->startOfMonth();
            $to = Carbon::now()->endOfMonth();
            $q->whereBetween('updated_at', [$from, $to]);
        })->when($time === 'daily', function ($q) {
            $q->whereDate('updated_at', Carbon::today());
        })->when($time === 'weekly', function ($q) {
            $from = Carbon::now()->startOfWeek();
            $to = Carbon::now()->endOfWeek();
            $q->whereBetween('updated_at', [$from, $to]);
        })
        ->whereHas('user', function ($q) {
            $q->where('account_type', 'public');
        })
        ->orderBy('count', 'desc')
        ->with('user')
        ->take(25)
        ->get();
    
        return TopWarriorResource::collection($data);
    }
}
