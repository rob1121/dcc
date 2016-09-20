<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;

class InternalSpecification implements SpecificationGateway {
    /**
     * @var CompanySpec
     */
    private $spec;

    public function __construct(CompanySpec $spec=null)
    {
        $this->spec = $spec;
    }

    function persist(Request $request) {
        return CompanySpec::create($this->modelInstance($request));

    }

    function update(Request $request) {
        $this->spec->update($this->modelInstance($request));
    }

    protected function modelInstance($request) {
        $newCompanySpecInstance = new CompanySpec($request->all());
        return $newCompanySpecInstance->toArray();
    }
}