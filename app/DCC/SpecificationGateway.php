<?php namespace App\DCC;

use Illuminate\Http\Request;

Interface SpecificationGateway
{
    function persist(Request $request);

    function update(Request $request);
}