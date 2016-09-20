<?php

Route::group(["prefix" => "api"], function() {
	Route::get( "/search", "ApiController@search" );
});