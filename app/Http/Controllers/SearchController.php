<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use TomLingham\Searchy\Facades\Searchy;
use App\CompanySpec;

class SearchController extends Controller
{
    /**
     * it search for given keyword
     * @param Request $request
     */
    public function search(Request $request)
    {
        return collect(Searchy::company_specs("spec_no","name")->query($request->q)->get())->map(function($item) {
        	return CompanySpec::find($item->id);
        });
    }
}
