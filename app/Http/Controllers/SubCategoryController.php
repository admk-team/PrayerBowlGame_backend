<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('admin.subcategory.createoredit');
    // }
    public function create(Request $request)
    {

        $categoryId = $request->query('category');
        return view('admin.subcategory.createoredit', compact('categoryId'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'nullable',
            'cat_id' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('admin_assets/subcategory'), $imageName);
            $imageName = 'admin_assets/subcategory/' .  $imageName;
            $validated['image'] = $imageName;
        } else {
            $validated['image'] = null;
        }

        $data = SubCategory::create($validated);
        if ($data) {
            return redirect()->route('category.show', $data->cat_id)->with('success', 'SubCategory created successfully!');
        } else {
            return back()->with('error', 'Failed to create SubCategory. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = SubCategory::findOrFail($id);
        return view('admin.subcategory.createoredit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = SubCategory::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'nullable',
            'cat_id' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('admin_assets/subcategory'), $imageName);
            $imageName = 'admin_assets/subcategory/' .  $imageName;
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
        if ($data) {
            return redirect()->route('category.show', $data->cat_id)->with('success', 'SubCategory updated successfully');
        } else {
            return back()->with('error', 'Failed to updated SubCategory. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = SubCategory::findOrFail($id);
        if ($data->image && file_exists(public_path($data->image))) {
            unlink(public_path($data->image));
        }
        $data->delete();
        return back()->with('success', 'SubCategory deleted successfully!');
    }
}
