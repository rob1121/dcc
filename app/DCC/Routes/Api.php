<?php

Route::group(["prefix" => "api"], function() {
    Route::get( "/internal/search", [
        "as" => "api.search.internal",
        "uses" => "ApiController@internalSearch"
    ]);

    Route::get( "/external/search", [
        "as" => "api.search.external",
        "uses" => "ApiController@externalSearch"
    ]);

});