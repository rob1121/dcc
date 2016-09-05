<?php namespace App\DCC\Company\AddCompanySpecs;

use App\CompanySpecCategory;

class AddSpecCategory extends SpecAbstract
{
    private $companySpecCategory;

    /**
     * if exist return ignore instance else insert request instance to database
     */
    public function add()
    {
        $this->setCompanySpecCategory();
        $this->spec->companySpecCategory()
            ->firstOrCreate($this->getCompanySpecCategory());
    }

    /**
     * set company specs category
     */
    public function setCompanySpecCategory()
    {
        $newCompanySpecCategoryInstance = collect(new CompanySpecCategory($this->request->all()));
        $this->companySpecCategory = $newCompanySpecCategoryInstance->toArray();
    }

    /**
     * get company specs category
     */
    public function getCompanySpecCategory()
    {
        return $this->companySpecCategory;
    }
}