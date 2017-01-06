<?php namespace App\DCC\External;

use App\CustomerSpec;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ExternalSpecCC implements SpecificationGateway {
    /**
     * CustomerSpec Class
     */
    private $spec;
    private $request;

    /**
     * ExternalSpecCC constructor.
     * @param Request $request
     * @param CustomerSpec $spec
     */
    function __construct(Request $request, CustomerSpec $spec=null) {
        $this->spec = $spec;
        $this->request = $request;
    }

    /**
     * insert collection of email to cc database
     */
    function persist() {
        $new_email_collection = (array) $this->sanitizedCcEmail();
        $this->spec->cc()->createMany( $new_email_collection );
    }

    /**
     * delete old email from cc and insert new
     */
    function update() {
        $this->spec->cc()->delete();
        $this->persist();
    }

    /**
     * remove email from request email if email is already exist
     * @return Collection
     */
    private function sanitizedCcEmail() {
        return collect($this->request->cc_email)
            ->map(function($email) {return ["email" => $email];})
            ->toArray();
    }
}