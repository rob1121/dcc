<?php namespace App\Dcc\API;

use Illuminate\Http\Request;

class Search
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function search()
    {

    }

    public function getRequest()
    {
        return $this->request;
    }
}