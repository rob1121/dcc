<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;

class InternalSpecCategory implements SpecificationGateway {
    private $spec;

    public function __construct(CompanySpec $spec=null) {
        $this->spec = $spec;
    }

    function persist(Request $request) {
        return $this->spec->companySpecCategory()->firstOrCreate($request->all());
    }

    function update(Request $request) {
        $this->spec->companySpecCategory()->update($this->modelInstance($request));
    }

    private function modelInstance(Request $request) {
        $newCompanySpecInstance = new CompanySpecCategory($request->all());
        return $newCompanySpecInstance->toArray();
    }
}