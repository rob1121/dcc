<?php

namespace App\Http\Controllers;

use App\Http\Requests\IsoRequest;
use App\Iso;

class IsoController extends Controller {
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

    }

    public function edit(Iso $iso) {

    }

    public function update(IsoRequest $request, Iso $iso) {

    }

    public function destroy(Iso $iso) {
        $iso->delete();
    }
}
