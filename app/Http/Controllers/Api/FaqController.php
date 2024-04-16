<?php

namespace App\Http\Controllers\Api;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::select(['id', 'question', 'answer'])->get();

        return response()->json([
            'status' => true,
            'data' => $faqs,
        ], 200);
    }
}
