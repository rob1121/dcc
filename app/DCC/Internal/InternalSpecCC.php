<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\DCC\SpecificationGateway;

class InternalSpecCC implements SpecificationGateway {
    /**
     * CustomerSpec Class
     */
    private $spec;
    private $emails;

    /**
     * InternalSpecCC constructor.
     * @param $emails
     * @param CompanySpec $spec
     */
    function __construct(array $emails, CompanySpec $spec = null)
    {
        $this->spec = $spec;
        $this->emails = $emails;
    }

    /**
     * insert collection of email to cc database
     */
    function persist()
    {
        $new_email_collection = (array) $this->sanitizedCcEmail();
        $this->spec->cc()->createMany($new_email_collection);
    }

    /**
     * delete old email from cc and insert new
     */
    function update()
    {
        $this->spec->cc()->delete();
        $this->persist();
    }

    /**
     * remove email from request email if email is already exist
     * @return Collection
     */
    private function sanitizedCcEmail()
    {
        return collect($this->emails)
            ->map(function ($email) {
                return ["email" => $email];
            })
            ->toArray();
    }
}