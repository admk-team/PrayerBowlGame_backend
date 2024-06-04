<?php

namespace App\Http\Controllers;

use App\Models\RequestCategory;
use Illuminate\Http\Request;

class RequestCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cat = RequestCategory::all();
        return view('admin.reqcategory.index', compact('cat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reqcategory.createoredit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('admin_assets/reqcategory'), $imageName);
            $imageName = 'admin_assets/reqcategory/' .  $imageName;
            $validated['image'] = $imageName;
        } else {
            $validated['image'] = null;
        }

        RequestCategory::create($validated);

        return redirect()->route('reqcategory.index')->with('success', 'Prayer Request Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $category = RequestCategory::with("subCategories")->findOrFail($id);
        // return view('admin.subcategory.index', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = RequestCategory::findOrFail($id);
        return view('admin.reqcategory.createoredit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = RequestCategory::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('admin_assets/reqcategory'), $imageName);
            $imageName = 'admin_assets/reqcategory/' .  $imageName;
            $validated['image'] = $imageName;

            if ($data->image) {
                $oldImagePath = public_path($data->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        } else {
            $validated['image'] = $data->image;
        }

        $data->update($validated);

        return redirect()->route('reqcategory.index')->with('success', 'Prayer Request Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = RequestCategory::findOrFail($id);
       
        // Delete category image if it exists
        if ($category->image && file_exists(public_path('images/reqcategory/' . $category->image))) {
            unlink(public_path('images/reqcategory/' . $category->image));
        }
        // Delete associated prayer requests for the category
        foreach ($category->prayerRequests as $prayerRequest) {
            $prayerRequest->delete();
        }
        // Delete the category
        $category->delete();
    
        return redirect()->route('reqcategory.index')->with('success', 'Prayer Request Category and its related data deleted successfully!');
    }
}

