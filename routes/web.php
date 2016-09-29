<?php

foreach(Illuminate\Support\Facades\File::allFiles(app_path('DCC\Routes')) as $route) {
    require $route->getPathname();
}

Route::get('/', function () {
    return redirect(route("internal.index"));
});

//Route::get("/", function() {
//    $user = User::first();
//    $user->notify(new SpecsUpdate);
////    Mail::to('telford@astigp.com')->send(new MailUpdatedSpecs);
//});

Auth::routes();

Route::get('/home', [
    "as" => "home",
    "uses" => 'HomeController@index'
]);

Route::get('/search', [
    "as" => "search",
    "uses" => 'SearchController@search'
]);