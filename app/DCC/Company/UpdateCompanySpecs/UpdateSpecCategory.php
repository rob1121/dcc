<?php namespace App\DCC\Company\UpdateCompanySpecs;
use App\CompanySpecCategory;

class UpdateSpecCategory extends UpdateSpecAbstract
{
    protected $companySpecsCategory;

    public function update()
    {
        $this->makeCompanySpecsInstance();
        $this->spec->companySpecCategory->update($this->companySpecsCategory);
    }

    /**
     *
     */
    private function makeCompanySpecsInstance()
    {
        $newCompanySpecInstance = collect(new CompanySpecCategory($this->request->all()));
        $this->companySpecsCategory = $newCompanySpecInstance->toArray();
    }
}