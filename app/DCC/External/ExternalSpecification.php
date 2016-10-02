<?php namespace App\DCC\External;

use App\CustomerSpec;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationFactory;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;

class ExternalSpecification implements SpecificationGateway {

    private $spec;
    private $factory;
    /**
     * @var Request
     */
    private $request;

    function __construct(Request $request, CustomerSpec $spec=null) {
        $this->factory = new SpecificationFactory;
        $this->spec = $spec;
        $this->request = $request;
    }

    function persist() {
        $this->spec = CustomerSpec::create(CustomerSpec::instance($this->request)->toArray());
        $this->factory->store(new ExternalSpecCategory($this->request, $this->spec));
            $this->factory->store(new ExternalSpecRevision($this->request, $this->spec));

        return $this->spec;
    }

    function update() {
        if ($this->spec === null) throw new SpecNotFoundException();
        $this->spec->update(CustomerSpec::instance($this->request)->toArray());
        $this->factory->update(new ExternalSpecCategory($this->request, $this->spec));
        $this->factory->update(new ExternalSpecRevision($this->request, $this->spec));
    }
}