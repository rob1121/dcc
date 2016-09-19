<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\CompanySpecRevision;
use App\DCC\SpecificationGateway;

class InternalSpecRevision implements SpecificationGateway {
    private $spec;

    public function __construct(CompanySpec $spec=null) {
        $this->spec = $spec;
    }

    function persist($request) {
        return  $this->spec->companySpecRevision()->firstOrCreate($this->modelInstance($request));
    }

    function update($request) {
        $this->spec->companySpecRevision->update($this->modelInstance($request));
    }

    private function modelInstance($request) {
        $newCompanySpecInstance = collect(new CompanySpecRevision($request->all()));
        return $newCompanySpecInstance->toArray();
    }
}