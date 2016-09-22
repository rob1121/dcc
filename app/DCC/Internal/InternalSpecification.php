<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\DCC\SpecificationGateway;
use App\DCC\SpecificationFactory;
use Illuminate\Http\Request;

class InternalSpecification implements SpecificationGateway {

    private $spec;
    private $factory;

    public function __construct(CompanySpec $spec=null) {
        $this->spec = $spec;
        $this->factory = new SpecificationFactory;
    }

    function persist(Request $request) {
        $this->spec = CompanySpec::create($this->modelInstance($request));
        $this->factory->store(new InternalSpecCategory($this->spec), $request);
        $this->factory->store(new InternalSpecRevision($this->spec), $request);

        return $this->spec;
    }

    function update(Request $request) {
        $this->spec->update($this->modelInstance($request));
        $this->factory->update(new InternalSpecRevision($this->spec), $request);
        $this->factory->update(new InternalSpecCategory($this->spec), $request);
    }

    protected function modelInstance($request) {
        $newCompanySpecInstance = new CompanySpec($request->all());
        return $newCompanySpecInstance->toArray();
    }
}