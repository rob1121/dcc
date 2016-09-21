<?php

Route::group(["prefix" => "api"], function() {
    Route::get( "/internal/search", "ApiController@internalSearch" );
    Route::get( "/external/search", "ApiController@externalSearch" );
});