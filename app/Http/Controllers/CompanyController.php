<?php namespace App\Http\Controllers;

use App\CompanySpec;
use App\DCC\Company\AddCompanySpecs\AddSpec;
use App\DCC\Company\UpdateCompanySpecs\UpdateSpec;
use App\DCC\Exceptions\DuplicateEntryException;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function form()
    {
        return view('company.create');
    }
    public function add(AddSpec $specs)
    {
        try {
            if (CompanySpec::isExist($specs->request))
                throw new DuplicateEntryException("Company Specification already exist!");

            $specs->validateSpec();
            $specs->add();
            return $specs->getResult();
        } catch(DuplicateEntryException $e) {
            return $e->getMessage();
        }
    }

    public function edit(CompanySpec $companySpec)
    {
        return view('company.edit', ['spec' => $companySpec->load(['companySpecRevision', 'companySpecCategory'])]);
    }

    public function update(UpdateSpec $spec, CompanySpec $companySpec)
    {
        $spec->setSpec($companySpec);
        dd($companySpec);
    }
}
