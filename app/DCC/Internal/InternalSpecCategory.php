<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\DCC\SpecificationGateway;

class InternalSpecCategory implements SpecificationGateway {
    private $spec;

    public function __construct(CompanySpec $spec=null) {
        $this->spec = $spec;
    }

    function persist($request) {
        return $this->spec->companySpecCategory()->firstOrCreate($this->modelInstance($request));
    }

    function update($request) {
        $this->spec->companySpecCategory->update($this->modelInstance($request));
    }

    private function modelInstance($request) {
        $newCompanySpecInstance = collect(new CompanySpecCategory($request->all()));
        return $newCompanySpecInstance->toArray();
    }
}