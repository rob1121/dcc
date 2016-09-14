<?php namespace App\Http\Controllers;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\DCC\Company\AddCompanySpecs\AddSpec;
use App\DCC\Company\UpdateCompanySpecs\UpdateSpec;
use App\DCC\Exceptions\DuplicateEntryException;
use App\DCC\File\Document;
use JavaScript;

class CompanyController extends Controller
{
    public function index()
    {
        $categories = CompanySpecCategory::getCategoryList();
        JavaScript::put([
            'category_no' => $categories->first()->category_no,
            'category_name' => $categories->first()->category_name
        ]);

        return view('company.index', [
            "categories" => $categories
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
     * @param CompanySpec $internal
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(CompanySpec $internal)
    {
        $document = new Document($internal);
        return $document->showPDF();
    }

    /**
     * display view edit
     * @param CompanySpec $internal
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param CompanySpec $companySpec
     */
    public function edit(CompanySpec $internal)
    {
        return view('company.edit', ['spec' => $internal]);
    }

    /**
     * update database
     * @method patch
     * @param UpdateSpec $spec
     * @param CompanySpec $internal
     * @return mixed
     * @internal param CompanySpec $companySpec
     */
    public function update(UpdateSpec $spec, CompanySpec $internal)
    {
        $spec->setSpec($internal);
        $spec->validateSpec();
        $spec->update();
        return redirect(route("internal.index"));
    }

    /**
     * delete database instance
     * @param CompanySpec $internal
     * @return mixed
     * @internal param CompanySpec $companySpec
     */
    public function destroy(CompanySpec $internal)
    {
        $internal->delete();
    }
}
