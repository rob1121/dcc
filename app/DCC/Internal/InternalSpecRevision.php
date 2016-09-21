<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\CompanySpecRevision;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;
use App\DCC\SpecificationFactory;

class InternalSpecRevision implements SpecificationGateway {
    private $spec;
    private $factory;

    public function __construct(CompanySpec $spec=null) {
        $this->spec = $spec;
        $this->factory = new SpecificationFactory;
    }

    function persist(Request $request) {
        $this->spec->companySpecRevision()->firstOrCreate($request->all());
        $this->factory->store(new InternalSpecFile($this->spec), $request);

        return $this->spec;
    }

    function update(Request $request) {
        $this->spec->companySpecRevision->update($this->modelInstance($request));
        $this->factory->update(new InternalSpecFile($this->spec), $request);
    }

    private function modelInstance($request) {
        $newCompanySpecInstance = new CompanySpecRevision($request->all());

        return $newCompanySpecInstance->toArray();
    }
}