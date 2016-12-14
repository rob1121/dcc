<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class departmentController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function departments(Request $request)
    {
        $departments = User::findQueryInDepartment($request->q);
        $users       = User::findQuery($request->q);
        return response([
            "departments" => $this->departmentTransformer( $departments ),
            "users"       => $this->userTransformer( $users )
        ]);
    }

    public function userTransformer($user)
    {
        return collect($user)->transform(function($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                'department' => $user->department->pluck('department')
            ];
        });
    }

    public function departmentTransformer($departments)
    {
        return collect($departments)->transform(function($department) {
                return $this->userTransformer($department);
        });
    }
}
