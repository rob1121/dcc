<?php namespace App\DCC\External;
use App\CustomerSpec;
use App\CustomerSpecRevision;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;

class ExternalSpecRevision implements SpecificationGateway {

    private $spec;

    public function __construct(CustomerSpec $spec=null) {
        $this->spec = $spec;
    }

    function persist(Request $request) {
        return $this->spec->customerSpecRevision()->firstOrCreate($request->all());
    }

    function update(Request $request) {
        $this->spec->customerSpecRevision()->update($this->modelInstance($request));
    }

    private function modelInstance($request) {
        $newCompanySpecInstance = new CustomerSpecRevision($request->all());
        return $newCompanySpecInstance->toArray();
    }
}