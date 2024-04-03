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
            if ($ministryPartner) {
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
            'order' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable',
        ]);

        $ministryPartner = new MinistryPartner();
        $ministryPartner->name = $request->input('name');
        $ministryPartner->link = $request->input('link');
        $ministryPartner->order = $request->input('order') ?? '1';
        $ministryPartner->facebook = $request->input('facebook');
        $ministryPartner->instagram = $request->input('instagram');
        $ministryPartner->twitter = $request->input('twitter');
        $ministryPartner->youtube = $request->input('youtube');
        $ministryPartner->whatsApp = $request->input('whatsApp');
        $ministryPartner->tik_tok = $request->input('tik_tok');
        $ministryPartner->linked_in = $request->input('linked_in');
        $ministryPartner->christian_circle = $request->input('christian_circle');
        $ministryPartner->email = $request->input('email');
        $ministryPartner->phone = $request->input('phone');
        // $ministryPartner->order= '0';


        if ($request->hasFile('logo')) {
            $logoOriginalName = $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('admin_assets/images'), $logoOriginalName);
            $ministryPartner->logo = 'admin_assets/images/' . $logoOriginalName;
        }

        // if ($request->hasFile('media_icon')) {
        //     $logoOriginalName1 = $request->file('media_icon')->getClientOriginalName();
        //     $request->file('media_icon')->move(public_path('admin_assets/images/social_icon'), $logoOriginalName1);
        //     $ministryPartner->media_icon = 'admin_assets/images/social_icon/' . $logoOriginalName1;
        // }

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
            'order' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable',
        ]);

        $ministryPartner->update([
            'name' => $request->input('name'),
            'link' => $request->input('link'),
            'order' => $request->input('order') ?? '1',
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'facebook' => $request->input('facebook'),
            'instagram' => $request->input('instagram'),
            'twitter' => $request->input('twitter'),
            'youtube' => $request->input('youtube'),
            'whatsApp' => $request->input('whatsApp'),
            'tik_tok' => $request->input('tik_tok'),
            'linked_in' => $request->input('linked_in'),
            'christian_circle' => $request->input('christian_circle'),
        ]);

        if ($request->hasFile('logo')) {
            $logoOriginalName = $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('admin_assets/images'), $logoOriginalName);
            $ministryPartner->update(['logo' => 'admin_assets/images/' . $logoOriginalName]);
        }

        // if ($request->hasFile('media_icon')) {
        //     $logoOriginalName1 = $request->file('media_icon')->getClientOriginalName();
        //     $request->file('media_icon')->move(public_path('admin_assets/images/social_icon'), $logoOriginalName1);
        //     $ministryPartner->update(['media_icon' => 'admin_assets/images/social_icon/' . $logoOriginalName1]);
        // }

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
