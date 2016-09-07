<?php namespace App\DCC\Traits;


trait RequestSetter
{
    protected $request;

    public function setRequest($request)
    {
        $this->request = $request;
    }
}