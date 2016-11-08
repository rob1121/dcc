<?php namespace App\Http\Controllers;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\CustomerSpec;
use App\CustomerSpecCategory;
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
        $users = \App\User::allUser();

        return response()->json($users)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }
}
