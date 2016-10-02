<?php

Route::group(["prefix" => "iso"], function() {
    Route::get("/", [
        "uses" => "IsoController@index",
        "as" => "iso.index"
    ]);

    Route::get("/create", [
        "uses" => "IsoController@create",
        "as" => "iso.create"
    ]);

    Route::post("/", [
        "uses" => "IsoController@store",
        "as" => "iso.store"
    ]);

    Route::delete("/{iso}", [
        "uses" => "IsoController@destroy",
        "as" => "iso.destroy"
    ]);
});