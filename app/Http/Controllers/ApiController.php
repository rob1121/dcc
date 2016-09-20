<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class ApiController extends Controller
{
    public function search(Request $request) {
        $ids = \App\CompanySpecCategory::whereCategoryNo($request->category)
            ->get(['company_spec_id'])
            ->map(function($data) {
                return $data->company_spec_id;
            })->toArray();

        return response()->json(
            App\CompanySpec::whereIn('id', $ids)->paginate()
        )
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }
}
