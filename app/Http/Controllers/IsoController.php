<?php namespace App\Http\Controllers;

use App\DCC\Exceptions\DuplicateEntryException;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\File\Document;
use App\DCC\Iso\IsoDocument;
use App\DCC\SpecificationFactory;
use App\Http\Requests\IsoRequest;
use App\Iso;
use ErrorException;

class IsoController extends Controller {
    private $factory;

    public function __construct() {
        $this->middleware("auth.admin", ["only" => ["create","store","edit","update","destroy"]]);
        $this->middleware("server_push",["only" => ["index","edit","show","create"]]);
        $this->factory = new SpecificationFactory(); }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        \JavaScript::put("isos", Iso::all());
        return view("iso.index", ["show" => true ]); }

    /**
     * @param Iso $iso
     * @return mixed
     * @throws SpecNotFoundException
     */
    public function show(Iso $iso) {
        try { return (new Document($iso->document))->showPDF(); }
        catch (ErrorException $e) { throw new SpecNotFoundException("External Specification not found in the database"); } }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() { return view("iso.create"); }

    /**
     * @param IsoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws DuplicateEntryException
     */
    public function store(IsoRequest $request) {
        if(Iso::isExist($request)) throw new DuplicateEntryException("Already Exist in the database");
        $this->factory->store(new IsoDocument($request));
        return redirect()->route("iso.index"); }

    /**
     * @param Iso $iso
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Iso $iso) { return view("iso.edit", [ "iso" => $iso ]); }

    /**
     * @param IsoRequest $request
     * @param Iso $iso
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(IsoRequest $request, Iso $iso) {
        $this->factory->update(new IsoDocument($request, $iso));
        return redirect()->route("iso.index"); }

    /**
     * @param Iso $iso
     */
    public function destroy(Iso $iso) { $iso->delete(); }
}
