<?php

Route::get('/', function () {
   return view('welcome');
});

use App\User;
use Illuminate\Http\Request;

//Route::get("/", function() {
//    $user = User::first();
//    $user->notify(new SpecsUpdate);
////    Mail::to('telford@astigp.com')->send(new MailUpdatedSpecs);
//});

Route::get('/api/company-spec', function(Request $request) {

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
});


Auth::routes();

Route::get('/home', [
    "as" => "home",
    "uses" => 'HomeController@index'
]);

Route::get('/search', [
    "as" => "search",
    "uses" => 'SearchController@search'
]);

Route::resource('internal', "CompanyController");
