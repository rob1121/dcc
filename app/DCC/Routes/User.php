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

    Route::patch("/{user}", [
        "uses" => "UserController@update",
        "as" => "user.update"
    ]);

   Route::delete("/{user}", [
       "uses" => "UserController@delete",
       "as" => "user.delete"
   ]);
});