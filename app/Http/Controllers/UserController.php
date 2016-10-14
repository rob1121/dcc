<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
	public function __construct()
	{
		$this->middleware("auth.admin");
	}

    public function index()
    {
        return view( "user.index");
    }

    public function destroy(User $user)
    {
    	$user->delete();
    }
}
