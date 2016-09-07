<?php namespace App\DCC\Company\UpdateCompanySpecs;

use App\CompanySpec;
use App\CompanySpecRevision;
use App\DCC\Company\AddCompanySpecs\AddCompanySpecsInterface;
use App\DCC\Company\AddCompanySpecs\AddSpecFile;
use App\DCC\Company\AddCompanySpecs\AddSpecRevision;
use App\DCC\Company\ValidationRules;
use Illuminate\Http\Request;

class UpdateSpec
{

    public $request;
    private $result;
    private $spec;

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
     * @param mixed $spec
     */
    public function setSpec(CompanySpec $spec)
    {
        $this->spec = $spec;
    }

    /**
     * validate request instance
     */
    public function validateSpec()
    {
        (new ValidationRules)->validateSpec($this->request);
    }

    /**
     * add request instance to database using polymorphism
     */
    public function update()
    {
        $this->updateMorph(new UpdateCompanySpecs);
        $this->updateMorph(new UpdateSpecCategory);
        $this->updateMorph(new UpdateSpecRevision);
        $this->addMorph(new AddSpecFile);
        $this->setResult($this->spec);
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
        $this->spec = $rel->getSpec();
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
        $this->result = CompanySpec::find($spec->id);
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