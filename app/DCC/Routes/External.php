<?php

Route::group(["prefix" => "external"], function() {
    Route::get("/",[
        "as" => "external.index",
        "uses" => "ExternalController@index"
    ]);

    Route::get("/create",[
        "as" => "external.create",
        "uses" => "ExternalController@create"
    ]);

    Route::post("/",[
        "as" => "external.store",
        "uses" => "ExternalController@store"
    ]);

    Route::get("/{external}",[
        "as" => "external.show",
        "uses" => "ExternalController@show"
    ]);

    Route::get("/{external}/edit",[
        "as" => "external.edit",
        "uses" => "ExternalController@edit"
    ]);

    Route::patch("/{external}",[
        "as" => "external.update",
        "uses" => "ExternalController@update"
    ]);

    Route::delete("/{external}",[
        "as" => "external.destroy",
        "uses" => "ExternalController@destroy"
    ]);
});