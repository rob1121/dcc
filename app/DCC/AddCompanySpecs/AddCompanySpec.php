<?php namespace App\DCC\AddCompanySpecs;

use App\CompanySpec;
use App\CompanySpecCategory;
use Illuminate\Http\Request;

class AddCompanySpec implements AddCompanySpecsInterface
{
    /**
     * @var Request
     */
    private $request;
    private $rel;

    /**
     * validate request
     */
    public function validate()
    {
        $validation = new ValidateRequest;
        $validation->setRequest($this->request);
        $validation->setRules(CompanySpec::RULES);
    }

    /**
     * add requested data to company specs table
     */
    public function add()
    {
        $collection = collect(new CompanySpec($this->getRequest()))->toArray();
        $this->rel->companySpec()->save($collection);
        $this->syncRelation(new AddCompanySpecRevision, $id);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request->all();
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request, $rel = "")
    {
        $this->request = $request;
    }

    public function getResult()
    {
        // TODO: Implement getResult() method.
    }
}