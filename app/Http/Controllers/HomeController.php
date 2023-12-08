<?php

namespace App\Http\Controllers;

use App\Models\AddUser;
use App\Models\RandomUser;
use App\Models\User;
use Illuminate\Http\Request;
use Nette\Utils\Random;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userCount = User::count();
        $adduser = AddUser::count();
        $random_user = RandomUser::count(); // Count the number of users in the users table
        return view('admin.dashboard', compact('userCount','adduser','random_user'));
    }
}
