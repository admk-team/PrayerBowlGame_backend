<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cat = Category::all();
        return view('admin.category.index', compact('cat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.createoredit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('admin_assets/category'), $imageName);
            $imageName = 'admin_assets/category/' .  $imageName;
            $validated['image'] = $imageName;
        } else {
            $validated['image'] = null;
        }

        Category::create($validated);

        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::with("subCategories")->findOrFail($id);
        return view('admin.subcategory.index', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Category::findOrFail($id);
        return view('admin.category.createoredit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Category::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('admin_assets/category'), $imageName);
            $imageName = 'admin_assets/category/' .  $imageName;
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

        return redirect()->route('category.index')->with('success', 'Category  updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        // Delete associated subcategories
        foreach ($category->subcategories as $subcategory) {
            // Delete subcategory image if it exists
            if ($subcategory->image && file_exists(public_path('images/subcategory/' . $subcategory->image))) {
                unlink(public_path('images/subcategory/' . $subcategory->image));
            }
            $subcategory->delete();
        }
        // Delete category image if it exists
        if ($category->image && file_exists(public_path('images/category/' . $category->image))) {
            unlink(public_path('images/category/' . $category->image));
        }
        // Delete associated prayer requests for the category
        foreach ($category->prayerRequests as $prayerRequest) {
            $prayerRequest->delete();
        }
        // Delete the category
        $category->delete();
    
        return redirect()->route('category.index')->with('success', 'Category and its related data deleted successfully!');
    }
}
