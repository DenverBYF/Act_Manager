<?php

namespace App\Http\Controllers;

use App\Act;
use App\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$user = Auth::user();
    	$userName = $user->name;
    	$userCount = User::all()->count();
		$group = Role::all()->count();
		$act = Act::all()->count();
        return view('home',['user' => $user, 'userCount' => $userCount, 'group' => $group, 'act' => $act, 'userName' => $userName]);
    }
}
