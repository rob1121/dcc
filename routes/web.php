<?php

Route::get('/', function () {
   return view('welcome');
});

use App\User;

//Route::get("/", function() {
//    $user = User::first();
//    $user->notify(new SpecsUpdate);
////    Mail::to('telford@astigp.com')->send(new MailUpdatedSpecs);
//});
Route::get('/api/company-spec', function() {
    return App\CompanySpec::paginate();
});

Route::get('/api/users', function() {
    $request = request();

// handle sort option
    if (request()->has('sort')) {
        list($sortCol, $sortDir) = explode('|', request()->sort);
        $query = App\User::orderBy($sortCol, $sortDir);
    } else {
        $query = App\User::orderBy('id', 'asc');
    }

    if ($request->exists('filter')) {
        $query->where(function($q) use($request) {
            $value = "%{$request->filter}%";
            $q->where('name', 'like', $value)
                ->orWhere('email', 'like', $value);
        });
    }

    $perPage = request()->has('per_page') ? (int) request()->per_page : null;

// The headers 'Access-Control-Allow-Origin' and 'Access-Control-Allow-Methods'
// are to allow you to call this from any domain (see CORS for more info).
// This is for local testing only. You should not do this in production server,
// unless you know what it means.
    return response()->json(
        $query->paginate($perPage)
    )
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::resource('internal', "CompanyController");
