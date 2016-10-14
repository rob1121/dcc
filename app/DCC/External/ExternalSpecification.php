<?php namespace App\DCC\External;

use App\CustomerSpec;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationFactory;
use App\DCC\SpecificationGateway;
use App\Mail\ExternalSpecMailer;
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
        $this->spec = CustomerSpec::create(CustomerSpec::instance($this->request)->toArray());
        $this->factory->store(new ExternalSpecCategory($this->request, $this->spec));
        $this->factory->store(new ExternalSpecRevision($this->request, $this->spec));

        $this->notifyUser("New External Spec");

        return $this->spec;
    }

    function update() {
        if ($this->spec === null) throw new SpecNotFoundException();
        $this->spec->update(CustomerSpec::instance($this->request)->toArray());
        $this->factory->update(new ExternalSpecCategory($this->request, $this->spec));
        $this->factory->update(new ExternalSpecRevision($this->request, $this->spec));

        $this->notifyUser("External Spec Update");
    }


    protected function notifyUser($caption) {

        if ($this->request->send_notification) {
            $users = \App\User::whereUserType("REVIEWER")
                ->whereDepartment($this->spec->reviewer)
                ->orWhere("user_type","ADMIN")
                ->get();

            $spec = CustomerSpec::find($this->spec->id);
            $mail = new ExternalSpecMailer($spec, $caption);
            Mail::to($users)->send($mail);
        }
    }
}