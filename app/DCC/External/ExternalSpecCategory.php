<?php namespace App\DCC\External;

use App\CustomerSpec;
use App\CustomerSpecRevision;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;

class ExternalSpecCategory  implements SpecificationGateway {
    private $spec;

    public function __construct(CustomerSpec $spec)
    {
        $this->spec = $spec;
    }

    function persist(Request $request)
    {
        return $this->spec->customerSpecCategory()->firstOrCreate($request->all());
    }

    function update(Request $request)
    {
        $this->spec->customerSpecCategory->update($this->modelInstance($request));
    }

    private function modelInstance($request) {
        $newCompanySpecInstance = new CustomerSpecRevision($request->all());
        return $newCompanySpecInstance->toArray();
    }
}