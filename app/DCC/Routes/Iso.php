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

    Route::get("/{iso}", [
        "uses" => "IsoController@show",
        "as" => "iso.show"
    ]);

    Route::get("/{iso}/edit", [
        "uses" => "IsoController@edit",
        "as" => "iso.edit"
    ]);

    Route::patch("/{iso}", [
        "uses" => "IsoController@update",
        "as" => "iso.update"
    ]);

    Route::delete("/{iso}", [
        "uses" => "IsoController@destroy",
        "as" => "iso.destroy"
    ]);
});