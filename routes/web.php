<?php

use App\CompanySpec;
use App\Events\SomeEvent;
use App\Jobs\NotifyUserForSpecUpdate;
use App\Mail\MailSpecNewUpdate;
use App\Notifications\InternalSpecUpdateNotifier;
use App\User;
use Illuminate\Support\Facades\Mail;

foreach(Illuminate\Support\Facades\File::allFiles(app_path('DCC\Routes')) as $route) {
    require $route->getPathname();
}

Route::get('/', function () {

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