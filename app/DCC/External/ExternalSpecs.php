<?php namespace App\DCC\External;

use App\CustomerSpec;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationFactory;
use App\DCC\SpecificationGateway;
use App\Mail\ExternalSpecMailer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ExternalSpecs implements SpecificationGateway {

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
        $this->factory->store(new ExternalSpecCC($this->request->cc, $this->spec));

        $this->notifyUser("New External Spec");

        return $this->spec;
    }

    function update() {
        if ($this->spec === null) throw new SpecNotFoundException();

        $this->spec->update(CustomerSpec::instance($this->request));
        $this->factory->update(new ExternalSpecCategory($this->request, $this->spec));
        $this->factory->update(new ExternalSpecRevision($this->request, $this->spec));
        $this->factory->update(new ExternalSpecCC($this->request->cc, $this->spec));

        $this->notifyUser("External Spec Update");
    }


    protected function notifyUser( $caption ) {
        if ( $this->sendNotification() )
            Mail::to( $this->reviewers() )
                ->cc($this->request->cc?: [])
                ->send( $this->mailTemplate( $caption ) );
    }

    /**
     * @return bool
     */
    protected function sendNotification() {
        return json_decode($this->request->send_notification);
    }

    protected function reviewers() {
        return User::getReviewer($this->spec->reviewer);
    }

    protected function mailTemplate($message) {
        $customer_spec = CustomerSpec::find($this->spec->id);
        return new ExternalSpecMailer($customer_spec, $message);
    }
}