<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationGateway;
use App\DCC\SpecificationFactory;
use App\Mail\InternalSpecMailer;
use App\User;
use Illuminate\Http\Request;

class InternalSpecification implements SpecificationGateway {

    private $spec;
    private $factory;
    private $request;
    private $company_spec_instance;

    public function __construct(Request $request, CompanySpec $spec=null) {
        $this->spec                  = $spec;
        $this->factory               = new SpecificationFactory;
        $this->request               = $request;
        $this->company_spec_instance = CompanySpec::instance($this->request);
    }

    function persist() {
        $spec = $this->filterRequestToSpecInstance();
        $this->spec = CompanySpec::create( $spec );
        $this->factory->store(new InternalSpecOriginator($this->request, $this->spec));
        $this->factory->store(new InternalSpecCategory($this->request, $this->spec));
        $this->factory->store(new InternalSpecRevision($this->request, $this->spec));
        $this->notifyUser("New Internal Spec");

        return $this->spec;
    }

    function update() {
        if ($this->spec === null) throw new SpecNotFoundException();
        $this->spec->update($this->company_spec_instance);
        $this->factory->update(new InternalSpecOriginator($this->request, $this->spec));
        $this->factory->update(new InternalSpecRevision($this->request, $this->spec));
        $this->factory->update(new InternalSpecCategory($this->request, $this->spec));

        $this->notifyUser("Internal Spec Update");
    }

    private function filterRequestToSpecInstance()
    {
        $spec_no = CompanySpecCategory::generateSpecNo( $this->request );
        $this->company_spec_instance["spec_no"] = $spec_no->companySpec;
        dd($this->company_spec_instance);
        return array_add( $this->company_spec_instance, 'spec_no', $spec_no );
    }

    protected function notifyUser($caption)
    {
        if ( $this->sendNotification() )
        {
            $mail       = new InternalSpecMailer(CompanySpec::find($this->spec->id), $caption);
            $originator = User::departmentIsIn($this->spec->originator_departments);
            \Mail::to( $originator )->send($mail);
        }
    }

    protected function sendNotification()
    {
        return "true" === $this->request->send_notification;
    }
}