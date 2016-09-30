<?php namespace App\DCC\External;

use App\CustomerSpec;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationFactory;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;

class ExternalSpecification implements SpecificationGateway {

    private $spec;
    private $factory;

    function __construct(CustomerSpec $spec=null) {
        $this->factory = new SpecificationFactory;
        $this->spec = $spec;
    }

    function persist(Request $request) {
        $this->spec = CustomerSpec::create($this->modelInstance($request));
        $this->factory->store(new ExternalSpecCategory($this->spec), $request);
            $this->factory->store(new ExternalSpecRevision($this->spec), $request);

        return $this->spec;
    }

    function update(Request $request) {
        if ($this->spec === null) throw new SpecNotFoundException();
        $this->spec->update($this->modelInstance($request));
        $this->factory->update(new ExternalSpecCategory($this->spec), $request);
        $this->factory->update(new ExternalSpecRevision($this->spec), $request);
    }

    private function modelInstance($request) {
        return (new CustomerSpec($request->all()))->toArray();
    }
}