<?php namespace App\DCC\AddCompanySpecs;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\CompanySpecRevision;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class AddCompanySpecs implements AddCompanySpecsInterface
{
    use ValidatesRequests;
    
    private $request;
    private $companySpecCategory;
    private $companySpecRevision;
    private $result;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function add()
    {
        $request = $this->request->all();
        $spec = CompanySpec::create($request);

        $this->setCompanySpecCategory();
        $spec->companySpecCategory()->create($this->getCategory());

        $this->setCompanySpecRevision();
        $spec->companySpecRevision()->create($this->getRevision());
        $this->setResult($spec);
    }

    public function setCompanySpecCategory()
    {
        $this->companySpecCategory = collect(new CompanySpecCategory($this->request->all()))->toArray();
        dd($this->companySpecCategory);
    }

    public function getCategory()
    {
        return $this->companySpecCategory;
    }

    public function setCompanySpecRevision()
    {
        $this->companySpecRevision = collect(new CompanySpecRevision($this->request->all()))->toArray();
    }

    public function getRevision()
    {
        return $this->companySpecRevision;
    }

    public function validateSpec()
    {
        $this->validate($this->request, CompanySpec::RULES);
        $this->validate($this->request, CompanySpecRevision::RULES);
        $this->validate($this->request, CompanySpecCategory::RULES);
    }

    public function setResult($result)
    {
       $this->result = $result;
    }

    public function getResult()
    {
        return $this->result;
    }
}