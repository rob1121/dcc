<?php

Route::group(["prefix" => "esd"], function() {
    Route::get("/", [
        "uses" => "ESDController@index",
        "as" => "esd.index"
    ]);

    Route::get("/create", [
        "uses" => "ESDController@create",
        "as" => "esd.create"
    ]);

    Route::post("/", [
        "uses" => "ESDController@store",
        "as" => "esd.store"
    ]);

    Route::get("/{esd}", [
        "uses" => "ESDController@show",
        "as" => "esd.show"
    ]);

    Route::get("/{esd}/edit", [
        "uses" => "ESDController@edit",
        "as" => "esd.edit"
    ]);

    Route::patch("/{esd}", [
        "uses" => "ESDController@update",
        "as" => "esd.update"
    ]);

    Route::delete("/{esd}", [
        "uses" => "ESDController@destroy",
        "as" => "esd.destroy"
    ]);
});