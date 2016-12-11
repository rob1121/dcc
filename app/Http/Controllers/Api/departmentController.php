<?php namespace App\Http\Controllers\Api;

use App\Department;
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
        $user =  Department::searchInput(
            $request->input('query')
        );

        $departments = Department::findDepartments(
            $request->input('query')
        );

        return response(
            app('DepartmentTransformer')->transform([
                "department" => $departments,
                "user" => $user
            ])
        );
    }
}
