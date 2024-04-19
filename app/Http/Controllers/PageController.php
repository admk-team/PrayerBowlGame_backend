<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::get();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.createoredit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required',
            'content' => 'required',
        ]);

        Page::create($validatedData);

        return redirect()->route('page.index')->with('success', 'Page created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Page::find($id);
        return view('admin.pages.createoredit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'type' => 'required',
            'content' => 'required',
        ]);

        $data = Page::find($id);
        $data->update($validatedData);

        return redirect()->route('page.index')->with('success', 'Page updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Page::find($id)->delete();
        return back()->with('success', 'Page deleted successfully');
    }

    public function pages()
    {
        $page = Page::select(['id', 'type', 'content'])->get();

        return response()->json([
            'status' => true,
            'data' => $page,
        ], 200);
    }
}
