<?php
foreach(Illuminate\Support\Facades\File::allFiles(app_path('DCC\Routes')) as $route) {
    require $route->getPathname();
}

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', [
    "as" => "home",
    "uses" => 'HomeController@index'
]);

Route::get('/search', [
    "as" => "search",
    "uses" => 'SearchController@search'
]);