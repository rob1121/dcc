<?php namespace App\DCC\Company\AddCompanySpecs;

use App\CompanySpecRevision;

class AddSpecRevision extends SpecAbstract
{
    private $companySpecRevision;

    /**
     * insert request instance to database
     */
    public function add()
    {
        $this->setCompanySpecRevision();
        $this->spec->companySpecRevision()
            ->firstOrCreate($this->getCompanySpecRevision());
    }

    /**
     * set company category revision
     */
    public function setCompanySpecRevision()
    {
        $newCompanySpecRevisionInstance = collect(new CompanySpecRevision($this->request->all()));
        $this->companySpecRevision = $newCompanySpecRevisionInstance->toArray();
    }

    /**
     * get company category revision
     */
    public function getCompanySpecRevision()
    {
        return $this->companySpecRevision;
    }
}