<?php namespace App\DCC\Company\AddCompanySpecs;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\CompanySpecRevision;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class AddSpec
{
    use ValidatesRequests;

    public $request;
    private $result;
    private $spec = null;

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
    public function add()
    {
            $this->spec = $this->morph(new AddCompanySpecs);
            $this->morph(new AddSpecCategory);
            $this->morph(new AddSpecRevision);
            $this->morph(new AddSpecFile);
            $this->setResult($this->spec);
    }

    /**
     * company spec polymorphism
     * @param AddCompanySpecsInterface $rel
     * @return mixed
     */
    protected function morph(AddCompanySpecsInterface $rel)
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