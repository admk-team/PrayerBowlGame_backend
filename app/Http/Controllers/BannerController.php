<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    // Index page showing all banners
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banners.index', compact('banners'));
    }

    // Show the form for creating a new banner
    public function create()
    {
        return view('admin.banners.create');
    }

    // Store a newly created banner in the database
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_views' => 'nullable|integer|min:1',
            'max_clicks' => 'nullable|integer|min:1',
        ]);

        Banner::create($request->all());

        return redirect()->route('banners.index')->with('success', 'Banner created successfully!');
    }

    // Show the form for editing the specified banner
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    // Update the specified banner in the database
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'company_name' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_views' => 'nullable|integer|min:1',
            'max_clicks' => 'nullable|integer|min:1',
        ]);

        $banner->update($request->all());

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully!');
    }

    // Remove the specified banner from the database
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully!');
    }
}
