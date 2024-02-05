<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailSetting;

class EmailSettingsController extends Controller
{
    public function index()
    {
        $emailSettings = EmailSetting::first() ?? '';
        return view('admin.email-settings.index', compact('emailSettings'));
    }

    public function update(Request $request)
    {
        $emailSettings = EmailSetting::first();

        if ($emailSettings == '') 
        {
            $emailSettings = new EmailSetting;
        }
        $emailSettings->androidLink = $request->androidLink ?? '';
        $emailSettings->iosLink = $request->iosLink ?? '';
        $emailSettings->message = $request->message ?? '';
        $emailSettings->save();

        return back()->with('success', 'Email settings successfully updated.');
    }
}