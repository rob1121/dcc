<?php namespace App\DCC\Company\AddCompanySpecs;

use App\DCC\Company\ValidationRules;
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
     * validate request instance
     */
    public function validateSpec()
    {
        (new ValidationRules)->validateSpec($this->request);
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
     * company category polymorphism
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
     * set result load company category, revision and category
     * @param $spec
     */
    protected function setResult($spec)
    {
        $this->result = $spec;
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