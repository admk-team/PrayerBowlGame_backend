<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OtpMail;
use App\Mail\TestMail;
use App\Models\Banner;
use App\Models\AddUser;
use App\Models\RandomUser;
use App\Models\TopWarrior;
use App\Mail\PrayerUserMail;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class RandomUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = RandomUser::with('user')->orderBy('id', 'asc')->paginate(8);
        return view('admin.random_users.index', compact('users'));
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
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]);

        $user = new RandomUser();
        $user->user_id = $request->user()->id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        if ($user->save()) {
            return response()->json(['success' => true, 'message' => 'Random User data added successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to add user data.']);
        }
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = RandomUser::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully');
    }

    public function get_random_user(Request $request)
    {
        $user = AddUser::where('user_id', $request->user()->id)->inRandomOrder()->first();

        if ($user) {
            $now = \Carbon\Carbon::now();

            $randomBanner = Banner::where(function ($query) use ($now) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', $now);
            })
                ->where(function ($query) use ($now) {
                    $query->whereNull('end_date')
                        ->orWhere('end_date', '>=', $now);
                })
                ->where('views', '<', \Illuminate\Support\Facades\DB::raw('max_views'))
                ->where('clicks', '<', \Illuminate\Support\Facades\DB::raw('max_clicks'))
                ->first();
            if ($randomBanner) {
                $bannerUrl = route('show.banner', ['Id' => $randomBanner->id]);
            }
            $randomuser = RandomUser::create([
                'user_id' => $request->user()->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'registered_user' => $request->user()->name
            ]);
            $checkuser = User::where('email', $randomuser->email)->first();
            if ($checkuser) {
                Notification::create([
                    'content' => 'I hope this message finds you in good spirits. We wanted to reach out and share that  ' . $request->user()->name . ' is keeping you in their prayers at this very moment.',
                    'user_id' => $checkuser->id,
                ]);
            }

            $logineduser = auth()->user();
            if ($logineduser) {
                $topwarrior = TopWarrior::where('user_id', $logineduser->id)->first();
                if ($topwarrior) {
                    if ($topwarrior->count > 0) {
                        $topwarrior->update(['count' => $topwarrior->count + 1]);
                    } else {
                        $topwarrior->update(['count' => 1]);
                    }
                } else {
                    $createdwarrior = TopWarrior::create(['user_id' => $logineduser->id, 'count' => 1]);
                }
            }

            try {
                App::setLocale($logineduser->language);
                Mail::to($user->email)->send(new PrayerUserMail($request->user()->name, $user->first_name . ' ' . $user->last_name, $randomBanner->banner ?? null, $randomBanner->content ?? null, $bannerUrl ?? null));
            } catch (\Exception $e) {
            }



            return response()->json(['success' => true, 'data' => $user]);
        }

        return response()->json(['success' => false, 'message' => 'Please add names to your list.']);
    }

    // public function test()
    // {
    //     // return (new PrayerUserMail('sender', 'reciever'))->render();
    //     Mail::to('alikhan9585497@gmail.com')->send(new PrayerUserMail('sender', 'reciever'));
    //     return 'email sent';
    // }
}
