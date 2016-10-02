<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationGateway;
use App\DCC\SpecificationFactory;
use Illuminate\Http\Request;

class InternalSpecification implements SpecificationGateway {

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
        $this->spec = CompanySpec::create(CompanySpec::instance($this->request)->toArray());
        $this->factory->store(new InternalSpecCategory($this->request, $this->spec));
        $this->factory->store(new InternalSpecRevision($this->request, $this->spec));

        return $this->spec;
    }

    function update() {
        if ($this->spec === null) throw new SpecNotFoundException();
        $this->spec->update(CompanySpec::instance($this->request)->toArray());
        $this->factory->update(new InternalSpecRevision($this->request, $this->spec));
        $this->factory->update(new InternalSpecCategory($this->request, $this->spec));
    }
}