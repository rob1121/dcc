<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationGateway;
use App\DCC\SpecificationFactory;
use App\Mail\InternalSpecMailer;
use App\User;
use Illuminate\Http\Request;
use Mail;

class InternalSpecification implements SpecificationGateway {

    private $spec;
    private $factory;
    private $request;
    private $company_spec_instance;

    public function __construct(Request $request, CompanySpec $spec=null) {
        $this->spec = $spec;
        $this->factory = new SpecificationFactory;
        $this->request = $request;
        $this->company_spec_instance = CompanySpec::instance($this->request)->toArray();
    }

    function persist() {
        $this->spec = CompanySpec::create($this->company_spec_instance);
        $this->factory->store(new InternalSpecCategory($this->request, $this->spec));
        $this->factory->store(new InternalSpecRevision($this->request, $this->spec));

        $this->notifyUser("New Internal Spec");

        return $this->spec;
    }

    function update() {
        if ($this->spec === null) throw new SpecNotFoundException();
        $this->spec->update($this->company_spec_instance);
        $this->factory->update(new InternalSpecRevision($this->request, $this->spec));
        $this->factory->update(new InternalSpecCategory($this->request, $this->spec));

        $this->notifyUser("Internal Spec Update");
    }

    protected function notifyUser($caption) {
        if ($this->request->send_notification) {
            $mail = new InternalSpecMailer($this->spec, $caption);
            Mail::to(User::all())->send($mail);
        }
//            \Notification::send($users, new InternalSpecUpdateNotifier($this->spec,));
    }
}