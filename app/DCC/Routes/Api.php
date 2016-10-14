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

    Route::get( "/user/search", [
        "as" => "api.search.user",
        "uses" => "ApiController@userSearch"
    ]);

    Route::get( "/external/search-for-review", [
        "as" => "api.search.external.for_review",
        "uses" => "ApiController@forReviewSearch"
    ]);
});