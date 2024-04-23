<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve testimonials with associated user details
        $data = Testimonial::with('user')->get();
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
    public function show(Testimonial $testimonial)
    {
        //
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
    public function updateStatus($id)
    {
        // Find the testimonial by ID
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->status = "approved";
        $testimonial->save();

        // Return a response indicating success
        return response()->json(['success' => true, 'message' => 'Testimonial status updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        //
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
