<?php



foreach(Illuminate\Support\Facades\File::allFiles(app_path('DCC\Routes')) as $route) {
    require $route->getPathname();
}

Route::get('/demo', function() {
    return \Spatie\Activitylog\Models\Activity::all()->last();
    return view('demo');
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

