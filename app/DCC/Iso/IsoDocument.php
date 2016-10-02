<?php namespace App\DCC\Iso;

use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationFactory;
use App\DCC\SpecificationGateway;
use App\Iso;
use Illuminate\Http\Request;

class IsoDocument implements SpecificationGateway {

    private $iso;
    private $request;
    private $factory;

    function __construct(Request $request, Iso $iso=null) {
        $this->iso = $iso;
        $this->request = $request;
        $this->factory = new SpecificationFactory;
    }

    function persist() {
        $this->iso = Iso::create(Iso::instance($this->request)->toArray());
        $this->factory->store(new IsoFile($this->request, $this->iso));
        return $this->iso;
    }

    function update() {
        if ($this->iso === null) throw new SpecNotFoundException("Iso spec is null");

        $this->iso->update(Iso::instance($this->request)->toArray());
        $this->factory->update(new IsoFile($this->request, $this->iso));
    }
}