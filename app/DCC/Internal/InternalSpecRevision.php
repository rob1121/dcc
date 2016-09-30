<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\CompanySpecRevision;
use App\DCC\Exceptions\SpecNotFoundException;
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
        if ($this->spec === null) throw new SpecNotFoundException();

        $this->spec->companySpecRevision->update(CompanySpecRevision::instance($request)->toArray());
        $this->factory->update(new InternalSpecFile($this->spec), $request);
    }
}