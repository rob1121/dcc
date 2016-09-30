<?php namespace App\DCC\Iso;

use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationGateway;
use App\Iso;
use Illuminate\Http\Request;

class IsoDocument implements SpecificationGateway {

    private $iso;

    function __construct(Iso $iso=null) {
        $this->iso = $iso;
    }

    function persist(Request $request)
    {
        return Iso::create(Iso::instance($request)->toArray());
    }

    function update(Request $request)
    {
        if ($this->iso === null) throw new SpecNotFoundException();

        $this->iso->update(Iso::instance($request)->toArray());
    }
}