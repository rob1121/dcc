<?php namespace App\DCC\Company\UpdateCompanySpecs;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\CompanySpecRevision;
use App\DCC\Company\AddCompanySpecs\AddCompanySpecsInterface;
use App\DCC\Company\AddCompanySpecs\AddSpecFile;
use App\DCC\Company\AddCompanySpecs\AddSpecRevision;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class UpdateSpec
{
    use ValidatesRequests;

    public $request;
    private $result;
    private $spec;

    /**
     * @param mixed $spec
     */
    public function setSpec(CompanySpec $spec)
    {
        dd($spec);
        $this->spec = $spec;
    }

    /**
     * AddSpec constructor.
     * get form inputs
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * validate specification
     */
    public function validateSpec()
    {
        $this->validate($this->request, $this->validationRules());
    }

    /**
     * validation rules
     * @return array
     */
    private function validationRules()
    {
        return collect(CompanySpec::RULES)
            ->merge(CompanySpecRevision::RULES)
            ->merge(CompanySpecCategory::RULES)
            ->toArray();
    }

    /**
     * add request instance to database using polymorphism
     */
    public function update()
    {
        $this->spec = $this->updateMorph(new UpdateCompanySpecs);
        $this->updateMorph(new UpdateSpecCategory);
        $this->updateSpecRevision();
        $this->addMorph(new AddSpecFile);
        $this->setResult($this->spec);
    }

    /**
     * if new instance already exist update database else insert new instance
     */
    protected function updateSpecRevision()
    {
        if (CompanySpecRevision::isExist($this->spec->id, $this->request->revision))
            $this->updateMorph(new UpdateSpecRevision);
        else
            $this->addMorph(new AddSpecRevision);
    }

    /**
     * company spec polymorphism
     * @param UpdateSpecsInterface $rel
     * @return mixed
     */
    protected function updateMorph(UpdateSpecsInterface $rel)
    {
        $rel->setRequest($this->request);
        $rel->setSpec($this->spec);
        $rel->update();
        return $rel->getSpec();
    }

    /**
     * company spec polymorphism
     * @param AddCompanySpecsInterface $rel
     * @return mixed
     */
    protected function addMorph(AddCompanySpecsInterface $rel)
    {
        $rel->setRequest($this->request);
        $rel->setSpec($this->spec);
        $rel->add();
        return $rel->getSpec();
    }

    /**
     * set result load companyspec, revision and category
     * @param $spec
     */
    public function setResult($spec)
    {
        $this->result = $spec->load(['companySpecRevision','companySpecCategory']);
    }

    /**
     * get result
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

}