<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\CompanySpecRevision;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;

class InternalSpecRevision implements SpecificationGateway {
    private $spec;

    public function __construct(CompanySpec $spec=null) {
        $this->spec = $spec;
    }

    function persist(Request $request) {
        return  $this->spec->companySpecRevision()->firstOrCreate($request->all());
    }

    function update(Request $request) {
        $this->spec->companySpecRevision->update($this->modelInstance($request));
    }

    private function modelInstance($request) {
        $newCompanySpecInstance = new CompanySpecRevision($request->all());
        return $newCompanySpecInstance->toArray();
    }
}