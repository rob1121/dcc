<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\DCC\SpecificationGateway;

class InternalSpecification implements SpecificationGateway {
    /**
     * @var CompanySpec
     */
    private $spec;

    public function __construct(CompanySpec $spec=null)
    {
        $this->spec = $spec;
    }

    function persist($request) {
        return CompanySpec::create($this->modelInstance($request));

    }

    function update($request) {
        $this->spec->update($this->modelInstance($request));
    }

    protected function modelInstance($request) {
        $newCompanySpecInstance = collect(new CompanySpec($request->all()));
        return $newCompanySpecInstance->toArray();
    }
}