<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailSettingsController extends Controller
{
    public function index()
    {
        return view('admin.email-settings.index');
    }
}
