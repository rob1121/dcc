<?php namespace App\Http\Controllers;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\DCC\Company\AddCompanySpecs\AddSpec;
use App\DCC\Company\UpdateCompanySpecs\UpdateSpec;
use App\DCC\Exceptions\DuplicateEntryException;

class CompanyController extends Controller
{
    public function index()
    {
        return view('company.index', [
            "specs" => CompanySpec::simplePaginate(),
            "categories" => CompanySpecCategory::getCategoryList()
        ]);
    }
    /**
     * display view create
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * store instance to database
     * @method post
     * @param AddSpec $specs
     * @return mixed|string
     */
    public function store(AddSpec $specs)
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

    /**
     * display view edit
     * @param CompanySpec $companySpec
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(CompanySpec $internal)
    {
        return view('company.edit', ['spec' => $internal]);
    }

    /**
     * update database
     * @method patch
     * @param UpdateSpec $spec
     * @param CompanySpec $companySpec
     * @return mixed
     */
    public function update(UpdateSpec $spec, CompanySpec $internal)
    {
        $spec->setSpec($internal);
        $spec->validateSpec();
        $spec->update();
        return $spec->getResult();
    }

    /**
     * delete database instance
     * @param UpdateSpec $spec
     * @param CompanySpec $companySpec
     * @return mixed
     */
    public function destroy(UpdateSpec $spec, CompanySpec $internal)
    {
        $spec->setSpec($internal);
        $spec->validateSpec();
        $spec->update();
        return $spec->getResult();
    }
}
