<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MinistryPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MinistryPartnerController extends Controller
{
    public function index()
    {
        $ministryPartners = MinistryPartner::orderBy('order')->get();
        return response()->json(['data' => $ministryPartners]);
    }

    public function show($id)
    {
        $ministryPartner = MinistryPartner::findOrFail($id);
        return response()->json(['data' => $ministryPartner]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $ministryPartner = new MinistryPartner();
        $ministryPartner->name = $request->input('name');
        $ministryPartner->link = $request->input('link');

        if ($request->hasFile('logo')) 
        {
            $logoOriginalName = $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('admin_assets/images'), $logoOriginalName);
            $ministryPartner->logo = 'admin_assets/images/' . $logoOriginalName;
        }

        $ministryPartner->save();
        return response()->json(['message' => 'Ministry Partner created successfully', 'data' => $ministryPartner], 201);
    }

    public function update(Request $request, $id)
    {
        $ministryPartner = MinistryPartner::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $ministryPartner->update([
            'name' => $request->input('name'),
            'link' => $request->input('link'),
        ]);

        if ($request->hasFile('logo')) {
            $logoOriginalName = $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('admin_assets/images'), $logoOriginalName);
            $ministryPartner->update(['logo' => 'admin_assets/images/' . $logoOriginalName]);
        }

        return response()->json(['message' => 'Ministry Partner updated successfully', 'data' => $ministryPartner]);
    }

    public function destroy($id)
    {
        $ministryPartner = MinistryPartner::findOrFail($id);
        $ministryPartner->delete();

        return response()->json(['message' => 'Ministry Partner deleted successfully']);
    }
}
