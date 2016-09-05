<?php
//
//Route::get('/', function () {
//    return view('welcome');
//});

use App\Mail\MailUpdatedSpecs;
use App\Notifications\SpecsUpdate;
use App\User;

Route::get("/", function() {
    $user = User::first();
    $user->notify(new SpecsUpdate);
//    Mail::to('telford@astigp.com')->send(new MailUpdatedSpecs);
});

Route::get('/form', "CompanyController@form");
Route::post('/add', "CompanyController@add");
Route::get('/edit/{companySpec}', "CompanyController@edit");
Route::post('/update/{companySpec}', "CompanyController@update");