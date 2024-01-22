<?php

namespace App\Http\Controllers;
use App\Models\MinistryPartner;

use Illuminate\Http\Request;

class MinistryPartnerController extends Controller
{
    public function index()
    {
        $ministryPartners = MinistryPartner::all();

        return view('admin.ministrypartner.index', compact('ministryPartners'));
    }

    public function create(Request $request)
    {
        $ministryPartners = MinistryPartner::all();
        return view('admin.ministryPartner.create',compact('ministryPartners'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $ministryPartner = new MinistryPartner();
        $ministryPartner->name = $request->input('name');
        
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->storeAs('public\admin_assets\images', $request->file('logo')->getClientOriginalName());
            $ministryPartner->logo = str_replace('public/', '', $logoPath);
        }

        $ministryPartner->save();

        return redirect()->route('ministryPartners.index')->with('success', 'Ministry Partner created successfully');
    }

    public function edit(MinistryPartner $ministryPartner)
    {
        return view('admin.ministryPartner.edit', compact('ministryPartner'));
    }
    

    public function update(Request $request, MinistryPartner $ministryPartner)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $ministryPartner->update($request->all());

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $ministryPartner->update(['logo' => $logoPath]);
        }

        return redirect()->route('ministryPartners.index')->with('success', 'Ministry Partner updated successfully');
    }

    public function show(MinistryPartner $ministryPartner)
    {
        $ministryPartners = MinistryPartner::all();
        return view('admin.ministryPartner.show', compact('ministryPartners'));
    }


    public function destroy(MinistryPartner $ministryPartner)
    {
        $ministryPartner->delete();

        return redirect()->route('admin.ministryPartner.index')->with('success', 'Ministry Partner deleted successfully');
    }
}
