<?php

namespace App\Http\Controllers;

use App\DCC\SpecificationFactory;
use App\ESD;
use Illuminate\Http\Request;

class ESDController extends Controller
{
    private $factory;

    public function __construct()
    {
        $this->middleware("auth");
        $this->middleware("auth.admin", ["only" => ["create","store","edit","update","destroy"]]);
        $this->middleware("server_push",["only" => ["index","edit","show","create"]]);
        $this->factory = new SpecificationFactory();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        \JavaScript::put("esd", ESD::all());
        return view("esd.index", ["show" => true ]);
    }
}
