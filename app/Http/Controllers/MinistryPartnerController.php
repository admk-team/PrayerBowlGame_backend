<?php

namespace App\Http\Controllers;

use App\Models\MinistryPartner;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MinistryPartnerController extends Controller
{
    public function index()
    {
        $ministryPartners = MinistryPartner::orderBy('order')->get();
        return view('admin.ministrypartner.index', compact('ministryPartners'));
    }

    // public function saveSortOrder(Request $request)
    // {
    //     $order = json_decode($request->order, true);
    //     foreach ($order as $itemOrder => $itemId) {
    //         DB::table('ministry_partners')->whereId($itemId)->update(['order' => $itemOrder]);
    //     }
    //     return response()->json(['message' => 'Sorting Saved'], 200);
    // }

    public function saveSortOrder(Request $request)
    {
        $order = json_decode($request->order, true);
        foreach ($order as $itemOrder => $itemId) {
            // Retrieve the associated data by ID
            $ministryPartner = MinistryPartner::find($itemId);
            // Update the order for the retrieved data
            if ($ministryPartner) 
            {
                $ministryPartner->update(['order' => $itemOrder + 1]);
            }
        }
        return response()->json(['message' => 'Sorting Saved'], 200);
    }

    public function create(Request $request)
    {
        $ministryPartners = MinistryPartner::all();
        return view('admin.ministrypartner.create', compact('ministryPartners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'required',
            'order' => 'required',
        ]);

        $ministryPartner = new MinistryPartner();
        $ministryPartner->name = $request->input('name');
        $ministryPartner->link = $request->input('link');
        $ministryPartner->order = $request->input('order');
        // $ministryPartner->order= '0';


        if ($request->hasFile('logo')) {
            $logoOriginalName = $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('admin_assets/images'), $logoOriginalName);
            $ministryPartner->logo = 'admin_assets/images/' . $logoOriginalName;
        }

        $ministryPartner->save();

        return redirect()->route('ministryPartners.index')->with('success', 'Ministry Partner created successfully');
    }

    public function edit(MinistryPartner $ministryPartner)
    {
        return view('admin.ministrypartner.edit', compact('ministryPartner'));
    }

    public function update(Request $request, MinistryPartner $ministryPartner)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'required',
            'order' => 'required',
        ]);

        $ministryPartner->update([
            'name' => $request->input('name'),
            'link' => $request->input('link'),
            'order' => $request->input('order'),
        ]);

        if ($request->hasFile('logo')) {
            $logoOriginalName = $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('admin_assets/images'), $logoOriginalName);
            $ministryPartner->update(['logo' => 'admin_assets/images/' . $logoOriginalName]);
        }

        return redirect()->route('ministryPartners.index')->with('success', 'Ministry Partner updated successfully');
    }


    public function show(MinistryPartner $ministryPartner)
    {
        // $ministryPartners = MinistryPartner::orderBy('id')->get();
        // return view('admin.ministrypartner.show', compact('ministryPartners'));
    }

    public function destroy(MinistryPartner $ministryPartner)
    {
        $ministryPartner->delete();
        return redirect()->route('ministryPartners.index')->with('success', 'Ministry Partner deleted successfully');
    }
}
