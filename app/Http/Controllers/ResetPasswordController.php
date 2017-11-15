<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    //change password
	public function  index(Request $request)
	{

		$user = Auth::user();
		if(Hash::check($request->old,$user->password)){
			$user->password = bcrypt($request->password);
			$user->save();
			return response("ok",200);
		}else{
			return response("password wrong", 400);
		}
	}
}
