<?php namespace App\DCC\External;

use App\CustomerSpec;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationFactory;
use App\DCC\SpecificationGateway;
use App\Mail\ExternalSpecMailer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ExternalSpecification implements SpecificationGateway {

    private $spec;
    private $factory;
    private $request;

    function __construct(Request $request, CustomerSpec $spec=null) {
        $this->factory = new SpecificationFactory;
        $this->spec = $spec;
        $this->request = $request;
    }

    function persist() {
        $this->spec = CustomerSpec::create(CustomerSpec::instance($this->request));

        $this->factory->store(new ExternalSpecCategory($this->request, $this->spec));
        $this->factory->store(new ExternalSpecRevision($this->request, $this->spec));

        $this->notifyUser("New External Spec");

        return $this->spec;
    }

    function update() {
        if ($this->spec === null) throw new SpecNotFoundException();
        $this->spec->update(CustomerSpec::instance($this->request));
        $this->factory->update(new ExternalSpecCategory($this->request, $this->spec));
        $this->factory->update(new ExternalSpecRevision($this->request, $this->spec));

        $this->notifyUser("External Spec Update");
    }


    protected function notifyUser( $caption )
    {
        if ( $this->sendNotification() )
            Mail::to( $this->reviewers() )
                ->cc($this->areaInvolved())
                ->send( $this->mailTemplate( $caption ) );
    }

    protected function areaInvolved()
    {
        return User::departmentIsIn($this->request->department);
    }

    protected function sendNotification()
    {
        return "true" === $this->request->send_notification;
    }

    protected function reviewers()
    {
        return User::getReviewer($this->spec->reviewer);
    }

    protected function mailTemplate($message)
    {
        $spec = CustomerSpec::find($this->spec->id);

        return new ExternalSpecMailer($spec, $message);
    }
}