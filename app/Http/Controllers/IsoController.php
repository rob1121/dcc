<?php namespace App\Http\Controllers;

use App\DCC\Exceptions\DuplicateEntryException;
use App\DCC\File\Document;
use App\DCC\Iso\IsoDocument;
use App\DCC\SpecificationFactory;
use App\Events\ISO\Delete;
use App\Events\ISO\Show;
use App\Events\ISO\Update;
use App\Http\Requests\IsoRequest;
use App\Iso;
use ErrorException;
use Illuminate\Support\Facades\Event;

class IsoController extends Controller 
{
    private $factory;

    function __construct() {
        $this->middleware("auth.admin", ["only" => ["create","store","edit","update","destroy"]]);
        $this->middleware("server_push",["only" => ["index","edit","show","create"]]);
        $this->factory = new SpecificationFactory();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index() {
        return view("iso.index", ["show" => true ]);
    }

    /**
     * @param Iso $iso
     * @return mixed
     */
    function show(Iso $iso) {
        try {
            $pdf = (new Document($iso->document))->showPDF();
            Event::fire(new Show($iso));
            return $pdf;
        } catch (ErrorException $e) {
            abort(406,"External Specification not found in the database");
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function create() {
        return view("iso.create");
    }

    /**
     * @param IsoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws DuplicateEntryException
     */
    function store(IsoRequest $request) {
        if(Iso::isExist($request)) throw new DuplicateEntryException("Already Exist in the database");
        $iso = $this->factory->store(new IsoDocument($request));
        Event::fire(new Store($iso));
        return redirect()->route("iso.index"); }

    /**
     * @param Iso $iso
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function edit(Iso $iso) {
        return view("iso.edit", [ "iso" => $iso ]);
    }

    /**
     * @param IsoRequest $request
     * @param Iso $iso
     * @return \Illuminate\Http\RedirectResponse
     */
    function update(IsoRequest $request, Iso $iso) {
        $this->factory->update(new IsoDocument($request, $iso));

        Event::fire(new Update($iso));
        return redirect()->route("iso.index"); }

    /**
     * @param Iso $iso
     */
    function destroy(Iso $iso) {
        $iso->delete();
        Event::fire(new Delete($iso->name));
    }
    
    function getAll() {
        return Iso::all();
    }
}
