<?php
Route::group(["prefix" => "user"], function() {
    Route::get("/", [
        "uses" => "UserController@index",
        "as" => "user.index"
    ]);

    Route::get("/{user}/edit", [
        "uses" => "UserController@edit",
        "as" => "user.edit"
    ]);

   Route::delete("/", [
       "uses" => "UserController@destroy",
       "as" => "user.destroy"
   ]);
});