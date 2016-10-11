<?php

use App\CompanySpec;
use Illuminate\Support\Facades\Mail;

foreach(Illuminate\Support\Facades\File::allFiles(app_path('DCC\Routes')) as $route) {
    require $route->getPathname();
}

Route::get('/', function () {
    $mail = new App\Mail\MailSpecNewUpdate(CompanySpec::first());

    Mail::to('robinsonlegaspi@astigp.com')->send($mail);
    return redirect(route("internal.index"));
});

//web.php
// Route::get("/", function() {
//     $user = User::first();
//     $spec = Companyspec::first();
//     $user->notify(new InternalSpecUpdateNotifier($spec));
// });


//    dispatch(new NotifyUserForSpecUpdate($spec));
//    $user->notify(new InternalSpecUpdateNotifier($spec));
//    Mail::to('robinsonlegaspi@astigp.com')->send(new MailUpdatedSpecs());
//    Mail::to('telford@astigp.com')->send(new MailUpdatedSpecs);

Auth::routes();

Route::get('/home', [
    "as" => "home",
    "uses" => 'HomeController@index'
]);

Route::get('/search', [
    "as" => "search",
    "uses" => 'SearchController@search'
]);