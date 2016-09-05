<?php namespace App\DCC\Company\AddCompanySpecs;

use App\CompanySpec;

class AddCompanySpecs extends SpecAbstract
{
    protected $companySpecs;

    public function add()
    {
        $this->setCompanySpecs();
        $this->spec = CompanySpec::create($this->getCompanySpecs());
    }

        public function setCompanySpecs()
        {
            $newCompanySpecInstance = collect(new CompanySpec($this->request->all()));
            $this->companySpecs = $newCompanySpecInstance->toArray();
        }

        public function getCompanySpecs()
        {
            return $this->companySpecs;
        }
}