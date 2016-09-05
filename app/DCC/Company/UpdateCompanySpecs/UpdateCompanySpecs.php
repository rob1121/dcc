<?php namespace App\DCC\Company\UpdateCompanySpecs;
use App\CompanySpec;

class UpdateCompanySpecs extends UpdateSpecAbstract
{
    protected $companySpecs;

    public function update()
    {
        $this->makeCompanySpecsInstance();
        $this->spec->update($this->companySpecs);
    }

    /**
     *
     */
    public function makeCompanySpecsInstance()
    {
        $newCompanySpecInstance = collect(new CompanySpec($this->request->all()));
        $this->companySpecs = $newCompanySpecInstance->toArray();
    }
}