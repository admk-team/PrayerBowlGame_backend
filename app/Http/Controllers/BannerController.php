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
        $request->validate([
            'company_name' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_views' => 'nullable|integer|min:1',
            'max_clicks' => 'nullable|integer|min:1',
        ]);

        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = public_path('admin_assets/banner_ad/' . $imageName);

            $image->move(public_path('admin_assets/banner_ad'), $imageName);
        }

        Banner::create([
            'company_name' => $request->input('company_name'),
            'content' => $request->input('content'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'max_views' => $request->input('max_views'),
            'max_clicks' => $request->input('max_clicks'),
            'banner' => isset($imageName) ? $imageName : null,
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully!');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    // public function update(Request $request, Banner $banner)
    // {
    //     $request->validate([
    //         'company_name' => 'required|string',
    //         'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         'content' => 'required|string',
    //         'start_date' => 'required|date',
    //         'end_date' => 'required|date|after:start_date',
    //         'max_views' => 'nullable|integer|min:1',
    //         'max_clicks' => 'nullable|integer|min:1',
    //     ]);

    //     if ($request->hasFile('banner')) {
    //         $image = $request->file('banner');
    //         $imageName = time() . '_' . $image->getClientOriginalName();
    //         $imagePath = public_path('admin_assets/banner_ad/' . $imageName);

    //         // Move the new uploaded file to the specified location in the public directory
    //         $image->move(public_path('admin_assets/banner_ad'), $imageName);

    //         // Delete the old image if it exists
    //         if ($banner->banner) {
    //             $oldImagePath = public_path('admin_assets/banner_ad/' . $banner->banner);
    //             if (file_exists($oldImagePath)) {
    //                 unlink($oldImagePath);
    //             }
    //         }
    //     }

    //     // Use input directly to update the model
    //     $banner->update($request->input());

    //     return redirect()->route('banners.index')->with('success', 'Banner updated successfully!');
    // }
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

        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = public_path('admin_assets/banner_ad/' . $imageName);

            $image->move(public_path('admin_assets/banner_ad'), $imageName);

            if ($banner->banner) {
                $oldImagePath = public_path('admin_assets/banner_ad/' . $banner->banner);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        } else {
            $imageName = $banner->banner;
        }

        $banner->update([
            'company_name' => $request->input('company_name'),
            'content' => $request->input('content'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'max_views' => $request->input('max_views'),
            'max_clicks' => $request->input('max_clicks'),
            'banner' => $imageName,
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully!');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully!');
    }
}
