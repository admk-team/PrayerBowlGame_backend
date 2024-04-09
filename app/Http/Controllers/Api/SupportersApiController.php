<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopWarriorResource;
use Illuminate\Http\Request;
use App\Models\Supporters;
use App\Models\TopWarrior;
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

    public function topwarriors()
    {
        $data = TopWarrior::orderBy('count', 'desc')->with('user')->take(25)->get();

        return TopWarriorResource::collection($data);
    }
}
