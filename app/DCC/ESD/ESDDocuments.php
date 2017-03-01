<?php namespace App\DCC\ESD;

use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationFactory;
use App\DCC\SpecificationGateway;
use App\ESD;
use Illuminate\Http\Request;

class ESDDocuments implements SpecificationGateway {

    private $esd;
    private $request;
    private $factory;

    function __construct(Request $request, ESD $iso=null) {
        $this->esd = $iso;
        $this->request = $request;
        $this->factory = new SpecificationFactory;
    }

    function persist() {
        $this->esd = ESD::create(ESD::instance($this->request->all()));
        $this->factory->store(new ESDFile($this->request, $this->esd));
        return $this->esd;
    }

    public function edit(ESD $esd) {
        return view("esd.edit", [ "esd" => $esd ]);
    }

    function update() {
        if ($this->esd === null) throw new SpecNotFoundException("ESD spec is null");

        $this->esd->update(ESD::instance($this->request->all()));
        $this->factory->update(new ESDFile($this->request, $this->esd));
    }

    public function delete(ESD $esd) {
        $esd->delete();
    }
}