<?php namespace App\DCC\External;

use App\CustomerSpec;
use App\CustomerSpecCategory;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;

class ExternalSpecCategory  implements SpecificationGateway {
    private $spec;
    private $request;

    public function __construct(Request $request, CustomerSpec $spec=null) {
        $this->spec = $spec;
        $this->request = $request;
    }

    function persist() {
        return $this->spec->customerSpecCategory()->firstOrCreate(CustomerSpecCategory::instance($this->request));
    }

    function update() {
        if ($this->spec === null) throw new SpecNotFoundException();
        $this->spec->customerSpecCategory()->update(CustomerSpecCategory::instance($this->request));
    }
}