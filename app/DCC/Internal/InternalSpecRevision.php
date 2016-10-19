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
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request, CompanySpec $spec=null) {
        $this->spec = $spec;
        $this->factory = new SpecificationFactory;
        $this->request = $request;
    }

    function persist() {
        $this->spec->companySpecRevision()->firstOrCreate(CompanySpecRevision::instance($this->request));
        $this->factory->store(new InternalSpecFile($this->request, $this->spec));

        return $this->spec;
    }

    function update() {
        if ($this->spec === null) throw new SpecNotFoundException();
        $this->spec->companySpecRevision->update(CompanySpecRevision::instance($this->request));
        $this->factory->update(new InternalSpecFile($this->request, $this->spec));
    }
}