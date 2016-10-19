<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationGateway;
use App\Originator;
use Illuminate\Http\Request;

class InternalSpecOriginator implements SpecificationGateway {
    private $spec;
    private $request;

    public function __construct(Request $request, CompanySpec $spec=null) {
        $this->spec = $spec;
        $this->request = $request;
    }

    public function persist()
    {
        $originator = $this->originatorInstanceOf(
            collect( $this->request->department )->toArray()
        );

        return $this->spec->originator()->createMany( $originator );
    }

    public function update()
    {
        if ($this->spec === null) throw new SpecNotFoundException();

        $this->spec->originator()->delete();
        $this->persist();
    }

    protected function originatorInstanceOf(array $departments)
    {
        return collect($departments)->map(
            function($department) { return ["department" => $department]; }
        )->toArray();
    }
}