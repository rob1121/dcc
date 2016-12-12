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
        return response([
            "departments" => User::findQueryInDepartment($request->q),
            "users" => User::findQuery($request->q)
        ]);
    }
}
