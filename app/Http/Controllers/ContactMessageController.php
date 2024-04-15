<?php

namespace App\Http\Controllers;

use App\Mail\SendContactMessage;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(6);
        return view('admin.contact_messages.index', compact('messages'));
    }

    public function destroy($id)
    {
        ContactMessage::find($id)->delete();
        return back()->with('success', 'Message deleted');
    }
}
