<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
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
        return view("user.index");
    }

    public function edit(User $user)
    {
        return view("auth.register", ["user" => $user]);
    }

    public function update(UserRequest $request, User $user)
    {
        $user_details = User::instance( $request );
        $user->update( $user_details );
        return redirect()->route("user.index");
    }

    public function destroy(User $user)
    {
    	$user->delete();
    }
}
