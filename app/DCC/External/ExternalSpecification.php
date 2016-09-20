<?php namespace App\DCC\External;

use App\CustomerSpec;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;

class ExternalSpecification implements SpecificationGateway {

    /**
     * @var CustomerSpec
     */
    private $spec;

    function __construct(CustomerSpec $spec=null) {

        $this->spec = $spec;
    }

    function persist(Request $request) {
        return CustomerSpec::create($this->modelInstance($request));
    }

    function update(Request $request) {
        $this->spec->update($this->modelInstance($request));
    }

    private function modelInstance($request)
    {
        return (new CustomerSpec($request->all()))->toArray();
    }
}