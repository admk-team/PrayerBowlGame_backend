<?php

namespace App\Http\Controllers;

use App\Mail\DeleteAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function handleMailForm(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);
        $data = User::where('email', $request->email)->get();
        $checkemail = $data->pluck('email')->first(); // Assuming you want the first email if there are multiple
        $check_id = $data->pluck('id')->first();
        if ($request->email == $checkemail) {
            $deleteAccountUrl = route('confirm.account.deletion', ['userId' => $check_id]);
            $to = $request->email;
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
            ];
            Mail::to($to)->send(new DeleteAccount($data, $deleteAccountUrl));
            return redirect()->back()->with('success', 'Email has been sent successfully.');
        } else {
            return redirect()->back()->withErrors(['email' => 'Email does not match our records.']);
        }
    }
    public function confirmAccountDeletion($userId)
    {
        $user = User::findorFail($userId);
        DB::transaction(function () use ($user) {
            $user->delete();
        }, 1);
        return redirect('/');
    }
}
