<?php
use App\CustomerSpec;

Route::get('/mail', function() {
    return App\User::cc();
    $mail_subject = \Str::upper("FOLLOW UP: list of customer specs for review");
    $data = [
        "specs" => CustomerSpec::forReview(),
        "sub_title" => config("dcc.sub_title", ""),
        "system" => config("dcc.title", ""),
    ];

    return view('emails.mail_external_spec_for_followup',[
        "mail_subject" => $mail_subject,
        "data" => $data
    ]);
});


foreach(Illuminate\Support\Facades\File::allFiles(app_path('DCC\Routes')) as $route) {
    require $route->getPathname();
}

Route::get('/demo', function() {
//$cust = CustomerSpec::first();
//    return App\User::getReviewer($cust->reviewer);
//    $reviewer = CustomerSpec::reviewer();
//    $to = App\User::followUp($reviewer);
//    $cc = App\User::all();
//
//    return $to;
//    return view('demo');
});

Route::get('/', 'HomeController@index');
Route::get('/documentation', 'HomeController@documentation');

Auth::routes();

Route::get('/home', [
    "as" => "home",
    "uses" => 'HomeController@index'
]);

Route::get('/search', [
    "as" => "search",
    "uses" => 'SearchController@search'
]);

Route::get('/department-list', [
    'as' => 'department.list',
    'uses' => 'Api\departmentController@departments'
]);

