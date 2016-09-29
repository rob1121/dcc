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
});