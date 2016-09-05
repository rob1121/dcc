<?php namespace App\DCC\Company\UpdateCompanySpecs;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\CompanySpecRevision;
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
        $this->spec = $this->morph(new UpdateCompanySpecs);
        $this->morph(new UpdateSpecCategory);
        $this->morph(new UpdateSpecRevision);
        $this->morph(new UpdateSpecFile());
        $this->setResult($this->spec);
    }

    /**
     * company spec polymorphism
     * @param UpdateSpecsInterface $rel
     * @return mixed
     */
    protected function morph(UpdateSpecsInterface $rel)
    {
        $rel->setRequest($this->request);
        $rel->setSpec($this->spec);
        $rel->update();
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