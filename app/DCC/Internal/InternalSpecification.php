<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationGateway;
use App\DCC\SpecificationFactory;
use App\Events\Internal\Store;
use App\Events\Internal\Update;
use App\Mail\InternalSpecMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Mail;

class InternalSpecification implements SpecificationGateway {

    private $spec;
    private $factory;
    private $request;
    private $company_spec_instance;

    function __construct(Request $request, CompanySpec $spec=null) {
        $this->spec                  = $spec;
        $this->factory               = new SpecificationFactory;
        $this->request               = $request;
        $this->company_spec_instance = CompanySpec::instance($this->request);
    }

    function persist(){
        $this->company_spec_instance["spec_no"] = CompanySpecCategory::generateSpecNo( $this->request );
        $this->spec = CompanySpec::create( $this->company_spec_instance );
        $this->factory->store(new InternalSpecOriginator($this->request, $this->spec));
        $this->factory->store(new InternalSpecCategory($this->request, $this->spec));
        $this->factory->store(new InternalSpecRevision($this->request, $this->spec));
        $this->factory->store(new InternalSpecCC($this->request, $this->spec));
        $this->notifyUser("New Internal Spec");

        Event::fire(new Store($this->spec));
        return $this->spec;
    }

    function update() {
        if ($this->spec === null) throw new SpecNotFoundException();
        $this->spec->update($this->company_spec_instance);
        $this->factory->update(new InternalSpecOriginator($this->request, $this->spec));
        $this->factory->update(new InternalSpecRevision($this->request, $this->spec));
        $this->factory->update(new InternalSpecCategory($this->request, $this->spec));
        $this->factory->update(new InternalSpecCC($this->request, $this->spec));

        Event::fire(new Update($this->spec));
        $this->notifyUser("Internal Spec Update");
    }

    protected function notifyUser($caption) {
        if ( $this->sendNotification() )
            Mail::to( $this->request->cc_email )->send( $this->mailTemplate($caption) );
    }

    protected function sendNotification() {
        return "true" === $this->request->send_notification;
    }

    protected function mailTemplate($caption) {
        return new InternalSpecMailer(CompanySpec::find($this->spec->id), $caption);
    }
}