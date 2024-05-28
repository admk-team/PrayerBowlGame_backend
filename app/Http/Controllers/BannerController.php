<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_views' => 'nullable|integer|min:1',
            'max_clicks' => 'nullable|integer|min:1',
            'link' => 'nullable|string',
        ]);
    
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('admin_assets/banner_ad'), $imageName);
            $validated['banner'] = $imageName;
        } else {
            $validated['banner'] = null;
        }
    
        Banner::create($validated);
    
        return redirect()->route('banners.index')->with('success', 'Banner created successfully!');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'company_name' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_views' => 'nullable|integer|min:1',
            'max_clicks' => 'nullable|integer|min:1',
            'link' => 'nullable|string',
        ]);
    
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('admin_assets/banner_ad'), $imageName);
            $validated['banner'] = $imageName;
    
            if ($banner->banner) {
                $oldImagePath = public_path('admin_assets/banner_ad/' . $banner->banner);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        } else {
            $validated['banner'] = $banner->banner;
        }
    
        $banner->update($validated);
    
        return redirect()->route('banners.index')->with('success', 'Banner updated successfully!');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully!');
    }
}
