<?php

namespace App\Http\Controllers\Auth;

use App\Events\user\Create;
use App\FollowUpCc;
use App\User;
use Illuminate\Support\Facades\Event;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth.admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'        => 'required|max:255',
            'email'       => 'required|email|max:255|unique:users',
            'departments'  => 'required',
            'user_type'   => "required",
            'employee_id' => 'required|unique:users,employee_id',
            'password'    => isset($data["user_type"]) && $data["user_type"] === "EMAIL RECEIVER ONLY" ? '' : 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'employee_id' => $data['employee_id'],
            'user_type'   => $data['user_type'],
            'password'    => bcrypt($data['password']),
        ]);

        $user->department()->createMany(
            $this->extractDepartments($data)
        );

        if(isset($data['copy_on_cc']))
            FollowUpCc::firstOrCreate(['user_id' => $user->id]);

        Event::fire(new Create($user));
    }

    private function extractDepartments(array $data) {
        $new_departments = collect($data['departments'])->map(function($department) {
            return ['department' => $department];
        })->toArray();

        return $new_departments;

    }
}
