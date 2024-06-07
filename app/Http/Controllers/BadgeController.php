<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    public function index()
    {
        $badges = Badge::all();
        return view('admin.badges.index', compact('badges'));
    }

    public function create()
    {
        return view('admin.badges.createoredit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|string|in:prayer,donation',
            'milestone_1' => 'required|integer',
            'milestone_2' => 'required|integer',
            'milestone_3' => 'required|integer',
        ]);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('admin_assets/badges'), $imageName);
            $imagePath = 'admin_assets/badges/' . $imageName;
            $validated['image'] = $imagePath;
        } else {
            $validated['image'] = null;
        }
    
        Badge::create($validated);
    
        return redirect()->route('badges.index')->with('success', 'Badge created successfully!');
    }

    public function show(Badge $badge)
    {
        return view('admin.badges.show', compact('badge'));
    }

    public function edit(Badge $badge)
    {
        return view('admin.badges.createoredit', compact('badge'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|in:prayer,donation',
            'milestone_1' => 'required|integer',
            'milestone_2' => 'required|integer',
            'milestone_3' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $badge = Badge::findOrFail($id);
    
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($badge->image && file_exists(public_path($badge->image))) {
                unlink(public_path($badge->image));
            }
    
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('admin_assets/badges'), $imageName);
            $imageName = 'admin_assets/badges/' . $imageName;
            $validated['image'] = $imageName;
        }
    
        $badge->update($validated);
    
        return redirect()->route('badges.index')->with('success', 'Badge updated successfully!');
    }
    

    public function destroy($id)
    {
        $badge = Badge::findOrFail($id);
        
        // Delete badge image if it exists
        if ($badge->image && file_exists(public_path($badge->image))) {
            unlink(public_path($badge->image));
        }
        
        // Delete the badge
        $badge->delete();
        
        return redirect()->route('badges.index')->with('success', 'Badge and its related data deleted successfully!');
    }
    
}

