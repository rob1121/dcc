<?php namespace App\Http\Controllers;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\CustomerSpec;
use App\CustomerSpecCategory;
use App\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function internalSearch(Request $request)
    {
        return response()->json(CompanySpec::orderBy("spec_no")->get())
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function externalSearch(Request $request)
    {
        $customer_spec = CustomerSpec::with(["customerSpecRevision" => function ($query) {
            $query->orderBy("revision", "asc");
        }, "customerSpecCategory"])->orderBy("spec_no")->get();
        return response()->json($customer_spec)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function userSearch()
    {
        $users = $this->userTransformer( User::get() );

        return response()->json($users)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function userTransformer($user)
    {
        if ($user instanceof User) {
            return [
                "id" => $user->id,
                "name" => $user->name,
                "user_type" => $user->user_type,
                "employee_id" => $user->employee_id,
                "email" => $user->email,
                "edit_route" => $user->edit_route,
                "delete_route" => $user->delete_route,
                "departments" => $user->departments
            ];
        }

        return $user->map(function($user) {
            return [
                "id" => $user->id,
                "name" => $user->name,
                "user_type" => $user->user_type,
                "employee_id" => $user->employee_id,
                "email" => $user->email,
                "edit_route" => $user->edit_route,
                "delete_route" => $user->delete_route,
                "departments" => $user->departments
            ];
        });
    }
}
