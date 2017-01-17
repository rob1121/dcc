<?php

Route::group(["prefix" => "log"], function() {
    Route::get("/", [
        "uses" => "LogController@index",
        "as" => "log.index"
    ]);

    Route::get("/all", [
        "uses" => "LogController@getAll",
        "as" => "log.all"
    ]);

    Route::get("/user/{user}", [
        "uses" => "LogController@getByUser",
        "as" => "log.getByUser"
    ]);

    Route::post("/date", [
        "uses" => "LogController@getByDate",
        "as" => "log.getByDate"
    ]);
});