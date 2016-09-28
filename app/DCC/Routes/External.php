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

    Route::get("/{external}/{revision?}",[
        "as" => "external.show",
        "uses" => "ExternalController@show"
    ]);

    Route::get("/spec/{external}/edit",[
        "as" => "external.edit",
        "uses" => "ExternalController@edit"
    ]);

    Route::patch("/{external}",[
        "as" => "external.update",
        "uses" => "ExternalController@update"
    ]);

    Route::patch("/{external}/update-status",[
        "as" => "external.revision.update",
        "uses" => "ExternalController@updateRevision"
    ]);

    Route::delete("/{external}",[
        "as" => "external.destroy",
        "uses" => "ExternalController@destroy"
    ]);
});