<?php namespace App\Http\Controllers;

use App\DCC\Internal\InternalSpecCategory;
use App\CompanySpec;
use App\CompanySpecCategory;
use App\DCC\Exceptions\DuplicateEntryException;
use App\DCC\File\Document;
use App\DCC\Internal\InternalSpecFile;
use App\DCC\Internal\InternalSpecification;
use App\DCC\Internal\InternalSpecRevision;
use App\DCC\SpecificationFactory;
use App\Http\Requests\CompanySpecRequest;
use JavaScript;

class InternalController extends Controller
{
    public function index()
    {
        $categories = CompanySpecCategory::getCategoryList();
        JavaScript::put([
            'category_no' => $categories->first()->category_no,
            'category_name' => $categories->first()->category_name
        ]);

        return view('internal.index', [
            "categories" => $categories
        ]);
    }
    /**
     * display view create
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('internal.create');
    }

    /**
     * store instance to database
     * @method post
     * @param CompanySpecRequest $request
     * @return mixed|string
     */
    public function store(CompanySpecRequest $request)
    {
        try {
            if (CompanySpec::isExist($request)) throw new DuplicateEntryException("Company Specification already exist!");

            $factory = new SpecificationFactory;
            $spec = $factory->store(new InternalSpecification, $request);
            $factory->store(new InternalSpecCategory($spec), $request);
            $factory->store(new InternalSpecRevision($spec), $request);
            $factory->store(new InternalSpecFile($spec), $request);
            return redirect(route("internal.index"));
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
        return view('internal.edit', ['spec' => $internal]);
    }

    /**
     * update database
     * @method patch
     * @param CompanySpecRequest $request
     * @param CompanySpec $internal
     * @return mixed
     * @internal param CompanySpec $companySpec
     */
    public function update(CompanySpecRequest $request, CompanySpec $internal)
    {
        $factory = new SpecificationFactory;
        $factory->update(new InternalSpecification($internal), $request);
        $factory->update(new InternalSpecRevision($internal), $request);
        $factory->update(new InternalSpecCategory($internal), $request);
        $factory->update(new InternalSpecFile($internal), $request);
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
