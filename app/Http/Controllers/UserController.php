<?php

namespace App\Http\Controllers;

use App\Events\user\Delete;
use App\Events\user\Update;
use App\FollowUpCc;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Event;

class UserController extends Controller
{
    private $categories;

    public function __construct() {
		$this->middleware("auth.admin");
        $this->categories = User::getCategoryList();
	}

    public function index() {
        $cetegories = $this->categories->map(function($user) {
            return [
                "category_no" => $user,
                "name"        => $user
            ];
        });

        return view("user.index", [
            "categories" => $cetegories
        ]);
    }

    public function edit(User $user){
        return view("auth.edit", ["user" => $user]);
    }

    public function update(UserRequest $request, User $user) {
        $user->update($this->extractUserData($request));
        $user->department()->delete();
        $user->department()->createMany($this->extractDepartments($request));


        if(isset($request->copy_on_cc))
            FollowUpCc::firstOrCreate(['user_id' => $user->id]);

        Event::fire(new Update($user));
        return redirect()->route("user.index");
    }

    public function delete(User $user) {
    	$user->delete();
        Event::fire(new Delete($user->name));
    }

    private function extractUserData($request) {
        $user_details = User::instance($request);

        if ($user_details['password']) $user_details['password'] = bcrypt($user_details['password']);
        else array_pull($user_details, 'password');

        return $user_details;
    }

    private function extractDepartments(UserRequest $request) {
        return collect($request->departments)->map(function($department) {
            return ['department' => $department];
        })->toArray();
    }
}
