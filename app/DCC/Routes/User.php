<?php
Route::group(["prefix" => "employee"], function() {
   Route::get("/", [
       "uses" => "UserController@index",
       "as" => "user.index"
   ]);

   Route::delete("/", [
       "uses" => "UserController@destroy",
       "as" => "user.destroy"
   ]);
});