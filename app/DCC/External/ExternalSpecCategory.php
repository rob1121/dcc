<?php namespace App\DCC\External;

use App\CustomerSpec;
use App\CustomerSpecCategory;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;

class ExternalSpecCategory  implements SpecificationGateway {
    private $spec;

    public function __construct(CustomerSpec $spec) {
        $this->spec = $spec;
    }

    function persist(Request $request) {
        return $this->spec->customerSpecCategory()->firstOrCreate($request->all());
    }

    function update(Request $request) {
        if ($this->spec === null) throw new SpecNotFoundException();
        $this->spec->customerSpecCategory()->update($this->modelInstance($request));
    }

    private function modelInstance($request) {
        $newCompanySpecInstance = new CustomerSpecCategory($request->all());
        return $newCompanySpecInstance->toArray();
    }
}