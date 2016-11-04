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
        $ids = CompanySpecCategory::get(['company_spec_id'])
            ->map(function ($data) {
                return $data->company_spec_id;
            })->toArray();

        $company_spec = CompanySpec::with(['companySpecRevision', 'companySpecCategory', 'originator'])
            ->whereIn('id', $ids)->orderBy("spec_no")->get();

        return response()->json($company_spec)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function externalSearch(Request $request)
    {
        $ids = CustomerSpecCategory::whereCustomerName($request->category)
            ->get(['customer_spec_id'])
            ->map(function ($data) {
                return $data->customer_spec_id;
            })->toArray();

        $customer_spec = CustomerSpec::with(["customerSpecRevision" => function ($query) {
            $query->orderBy("revision", "asc");
        }])->whereIn('id', $ids)->orderBy("spec_no")->get();

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
