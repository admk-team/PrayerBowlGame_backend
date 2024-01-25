<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supporters;

class SupportersController extends Controller
{
    public function index()
    {
        $supporters = Supporters::orderBy('id', 'DESC')->paginate(10);
        return view('admin.supporters.index', compact('supporters'));
    }

    public function show()
    {
        $supporters = Supporters::orderBy('id', 'DESC')->get();
        return view('admin.supporters.show', compact('supporters'));
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

        Supporters::create($request->all());

        return redirect()->route('supporters.index')
            ->with('success', 'Supporter added successfully');
    }
}