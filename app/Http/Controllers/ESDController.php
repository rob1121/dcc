<?php namespace App\Http\Controllers;

use App\DCC\ESD\ESDDocuments;
use App\DCC\Exceptions\DuplicateEntryException;
use App\DCC\File\Document;
use App\DCC\SpecificationFactory;
use App\ESD;
use App\Events\ESD\Delete;
use App\Events\ESD\Show;
use App\Events\ESD\Store;
use App\Events\ESD\Update;
use App\Http\Requests\ESDRequest;
use ErrorException;
use Illuminate\Support\Facades\Event;

class ESDController extends Controller
{
    private $factory;

    function __construct() {
        $this->middleware("auth");
        $this->middleware("auth.admin", ["only" => ["create","store","edit","update","destroy"]]);
        $this->middleware("server_push",["only" => ["index","edit","show","create"]]);
        $this->factory = new SpecificationFactory();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index() {
        return view("esd.index", ["show" => true ]);
    }

    function show(ESD $esd) {
        try {
            $pdf = (new Document($esd->document))->showPDF();
            Event::fire(new Show($esd));
            return $pdf;
        } catch (ErrorException $e) {
            abort(406,"External Specification not found in the database");
        }
    }
    
    function create() {
        return view("esd.create");
    }

    function store(ESDRequest $request) {
        if(ESD::isExist($request->all())) throw new DuplicateEntryException("Already Exist in the database");
        $esd = $this->factory->store(new ESDDocuments($request));
        Event::fire(new Store($esd));
        return redirect()->route("esd.index"); 
    }

    function edit(ESD $esd) {
        return view("esd.edit", [ "esd" => $esd ]);
    }

    function update(ESDRequest $request, ESD $esd) {
        $this->factory->update(new ESDDocuments($request, $esd));
        Event::fire(new Update($esd));
        return redirect()->route("esd.index");
    }

    function delete(ESD $esd) {
        $esd->delete();
        Event::fire(new Delete($esd->name));
    }

    function all() {
        return response()->json(ESD::all());
    }
}
