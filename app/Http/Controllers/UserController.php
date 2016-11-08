<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;

class UserController extends Controller
{
    private $categories;

    public function __construct()
	{
		$this->middleware("auth.admin");
        $this->categories = User::getCategoryList();
	}

    public function index()
    {
        return view("user.index", [
            "categories" => $this->categories->map(function($user) {
                return [
                    "category_no" => $user,
                    "name" => $user
                ];
            })
        ]);
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
