<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        Faq::create($validatedData);

        return back()->with('success', 'FAQ created successfully');
    }

    public function edit($id)
    {
        $faq = Faq::find($id);
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $faq = Faq::find($id);
        $faq->update($validatedData);

        return back()->with('success', 'FAQ updated successfully');
    }

    public function destroy($id)
    {
        Faq::find($id)->delete();
        return back()->with('success', 'FAQ deleted successfully');
    }
}
