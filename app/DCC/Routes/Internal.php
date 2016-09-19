<?php

Route::group(["prefix" => "internal"], function() {
    Route::get("/",[
        "as" => "internal.index",
        "uses" => "InternalController@index"
    ]);

    Route::get("/create",[
        "as" => "internal.create",
        "uses" => "InternalController@create"
    ]);

    Route::post("/",[
        "as" => "internal.store",
        "uses" => "InternalController@store"
    ]);

    Route::get("/{internal}",[
        "as" => "internal.show",
        "uses" => "InternalController@show"
    ]);

    Route::get("/{internal}/edit",[
        "as" => "internal.edit",
        "uses" => "InternalController@edit"
    ]);

    Route::patch("/{internal}",[
        "as" => "internal.update",
        "uses" => "InternalController@update"
    ]);

    Route::delete("/{internal}",[
        "as" => "internal.destroy",
        "uses" => "InternalController@destroy"
    ]);
});