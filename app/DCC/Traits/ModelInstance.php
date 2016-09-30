<?php namespace App\DCC\Traits;

use Illuminate\Http\Request;

trait ModelInstance
{
    public static function instance(Request $request)
    {
        return new self($request->all());
    }
}