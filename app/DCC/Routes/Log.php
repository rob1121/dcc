<?php

Route::group(["prefix" => "log"], function() {
    Route::get("/", [
        "uses" => "LogController@index",
        "as" => "log.index"
    ]);

    Route::post("/date", [
        "uses" => "LogController@getByDate",
        "as" => "log.getByDate"
    ]);
});