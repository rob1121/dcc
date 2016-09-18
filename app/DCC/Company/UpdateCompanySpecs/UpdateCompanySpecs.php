<?php namespace App\DCC\Company\UpdateCompanySpecs;

use App\CompanySpec;

class UpdateCompanySpecs extends UpdateSpecAbstract
{
    protected $companySpecs;

    /**
     * update companyspecs database
     */
    public function update()
    {
        $this->makeCompanySpecsInstance();
        $this->spec->update($this->companySpecs);
    }

    /**
     * make new instance of company specs
     */
    private function makeCompanySpecsInstance()
    {
        $newCompanySpecInstance = collect(new CompanySpec($this->request->all()));
        $this->companySpecs = $newCompanySpecInstance->toArray();
    }
}