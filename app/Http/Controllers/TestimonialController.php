<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve testimonials with associated user details
        $data = Testimonial::with('user')->orderBy('updated_at', 'DESC')->get();
        return view('admin.testimonials.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'testimonial' => 'required',
        ]);
    
        // Add the authenticated user's ID to the validated data
        $validatedData['user_id'] = auth()->id();
        // Create the testimonial
        Testimonial::create($validatedData);
    
        // Send a JSON response
        return response()->json(['success' => true, 'message' => 'Testimonial added successfully.']);
    }

    /**
     * Display the specified resource.
     */
    // public function show(Testimonial $testimonial)
    // {
    //     //
    // }
    public function show($id)
    {
        $testimonial = Testimonial::with('user')->findOrFail($id);
        return response()->json(['data' => $testimonial]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, $id)
    {
        // Validate the status input
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);
    
        // Find the testimonial by ID
        $testimonial = Testimonial::findOrFail($id);
        
        // Update the status based on the request
        $testimonial->status = $request->status;
        $testimonial->save();
        $checkuser = User::where('id', $testimonial->user_id)->first();
            if ($checkuser->sub_id) {
                $userIds = [$checkuser->sub_id];
            } else {
                $userIds = [];
            }
            App::setLocale($checkuser->language);
            if($testimonial->status=="approved"){
                $message = __('Your Testimonial has been approved');
            }
            if($testimonial->status =="rejected"){
                $message = __('Your Testimonial has been rejected');
            }
            if (!empty($message) && !empty($userIds)) {
                $result = $this->onesignal($message, $userIds);
            }
        // Return a response indicating success
        return response()->json(['success' => true, 'message' => 'Testimonial status updated successfully.']);
    }


    // public function updateStatus($id)
    // {
    //     // Find the testimonial by ID
    //     $testimonial = Testimonial::findOrFail($id);
    //     $testimonial->status="approved";
    //     $testimonial->save();
    //     $checkuser = User::where('id', $testimonial->user_id)->first();
    //     // dd($checkuser);
    //     $userIds = $checkuser->pluck('sub_id')->toArray();
    //     if ($checkuser) {
    //         $userIds = [$checkuser->sub_id];
    //     } else {
    //         $userIds = [];
    //     }
    //     $message=__("Your Testimonial has approved");
    //     if($message && $userIds){
    //         $result = $this->onesignal($message, $userIds);
    //     }
    //     // Return a response indicating success
    //     return response()->json(['success' => true, 'message' => 'Testimonial status updated successfully.']);
    // }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Testimonial::findOrFail($id);
        $data->delete();
        return back()->with('success', 'Testimonial deleted successfully!');
    }

    public function allTestimonials()
    {
        $data = Testimonial::where('status', 'approved')->with('user')->orderBy('updated_at', 'DESC')->get();
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }
}
