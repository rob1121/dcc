<?php
foreach(Illuminate\Support\Facades\File::allFiles(app_path('DCC\Routes')) as $route) {
    require $route->getPathname();
}
Route::get('/demo', function() {
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



Route::get('/trim', function() {
    return preg_replace("/[^a-z|^0-9|^A-Z]/", "-", '//');
});