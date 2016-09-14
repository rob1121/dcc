<?php namespace App\DCC\Company\UpdateCompanySpecs;

use App\CompanySpecRevision;

class UpdateSpecRevision extends UpdateSpecAbstract
{
    protected $companySpecsRevision;

    /**
     * update category revision
     */
    public function update()
    {
        $this->makeCompanySpecsInstance();
        $this->spec->companySpecRevision->update($this->companySpecsRevision);
    }

    /**
     * make new instance of revision
     */
    public function makeCompanySpecsInstance()
    {
        $newCompanySpecInstance = collect(new CompanySpecRevision($this->request->all()));
        $this->companySpecsRevision = $newCompanySpecInstance->toArray();
    }
}