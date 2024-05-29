<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class PrayerSectionController extends Controller
{
    public function index()
    {
        $data = Category::all();
        return response()->json(['all_category' => $data]);
    }
    public function show($id)
    {
        $data = Category::with("subCategories")->findOrFail($id);
        return response()->json(['show_category' => $data]);
    }
}
