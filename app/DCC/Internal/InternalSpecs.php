<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationGateway;
use App\DCC\SpecificationFactory;
use App\Mail\InternalSpecMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InternalSpecs implements SpecificationGateway {

    private $spec;
    private $factory;
    private $request;
    private $specInstance;

    function __construct(Request $request, CompanySpec $spec=null) {
        $this->spec                  = $spec;
        $this->factory               = new SpecificationFactory;
        $this->request               = $request;
        $this->specInstance = CompanySpec::instance($this->request);
    }

    function persist(){
        $this->specInstance["spec_no"] = CompanySpecCategory::generateSpecNo( $this->request );
        $this->spec = CompanySpec::create( $this->specInstance );
        $this->factory->store(new InternalSpecOriginator($this->request, $this->spec));
        $this->factory->store(new InternalSpecCategory($this->request, $this->spec));
        $this->factory->store(new InternalSpecRevision($this->request, $this->spec));
        $this->factory->store(new InternalSpecCC($this->request->cc, $this->spec));
        $this->notifyUser("New Internal Spec");

        return $this->spec;
    }

    function update() {
        if ($this->spec === null) throw new SpecNotFoundException();
        $this->spec->update($this->specInstance);
        $this->factory->update(new InternalSpecOriginator($this->request, $this->spec));
        $this->factory->update(new InternalSpecRevision($this->request, $this->spec));
//        $this->factory->update(new InternalSpecCategory($this->request, $this->spec));
        $this->factory->update(new InternalSpecCC($this->request->cc, $this->spec));

        $this->notifyUser("Internal Spec Update");
    }

    protected function notifyUser($caption) {
        if ( $this->sendNotification() ) {
            if($this->request->cc) {
                Mail::to($this->request->cc)->send( $this->mailTemplate($caption) );
            }
        }
    }

    /**
     * @return bool
     */
    protected function sendNotification() {
        return json_decode($this->request->send_notification);
    }

    protected function mailTemplate($caption) {
        return new InternalSpecMailer(CompanySpec::find($this->spec->id), $caption);
    }
}