<?php

namespace App\Http\Controllers;

use App\Models\PrayerRequest;
use Illuminate\Http\Request;

class PrayerRequestController extends Controller
{
    public function index()
    {
        $data = PrayerRequest::with('category', 'user')->get();
        return view('admin.prayrequest.index', compact('data'));
    }
    public function destroy($id)
    {
        $data = PrayerRequest::findOrFail($id);
        $data->delete();
        return back()->with('success', 'Prayer Request deleted successfully!');
    }
}
