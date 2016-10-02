<?php

namespace App\Http\Controllers;

use App\DCC\Exceptions\DuplicateEntryException;
use App\DCC\Iso\IsoDocument;
use App\DCC\SpecificationFactory;
use App\Http\Requests\IsoRequest;
use App\Iso;

class IsoController extends Controller {
    public function __construct() {
        $this->factory = new SpecificationFactory();
    }
    public function index() {
        \JavaScript::put("isos", Iso::all());

        return view("iso.index");
    }

    public function show(Iso $iso) {

    }

    public function create() {
        return view("iso.create");
    }

    public function store(IsoRequest $request) {
        if(Iso::isExist($request)) throw new DuplicateEntryException("Already Exist in the database");
        $this->factory->store(new IsoDocument($request));

        return redirect(route("iso.index"));
    }

    public function edit(Iso $iso) {

    }

    public function update(IsoRequest $request, Iso $iso) {

    }

    public function destroy(Iso $iso) {
        $iso->delete();
    }
}
