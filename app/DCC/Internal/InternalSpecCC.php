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
    function __construct($emails, CompanySpec $spec = null)
    {
        $this->spec = $spec;
        $this->emails = $emails;
    }

    /**
     * insert collection of email to cc database
     */
    function persist()
    {
        if($this->emails) {
            $this->spec->cc()->createMany(
                $this->sanitize($this->emails)
            );
        }
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
     * @param $emails
     * @return array
     */
    private function sanitize($emails)
    {
        if ($emails) {
            return collect($emails)
                ->map(function ($email) {
                    return ["email" => $email];
                })->toArray();
        }
    }
}