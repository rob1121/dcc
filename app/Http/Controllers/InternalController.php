<?php namespace App\Http\Controllers;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\DCC\Exceptions\DuplicateEntryException;
use App\DCC\File\Document;
use App\DCC\Internal\InternalSpecification;
use App\DCC\SpecificationFactory;
use App\Http\Requests\InternalSpecRequest;
use JavaScript;

class InternalController extends Controller {
    private $factory;
    private $categories;

    public function __construct(){
        $this->factory = new SpecificationFactory;
        $this->categories = CompanySpecCategory::getCategoryList();
    }

    public function index() {
        JavaScript::put([
            'category_no' => $this->categories->first()->category_no,
            'category_name' => $this->categories->first()->category_name
        ]);

        return view('internal.index', [
            "categories" => $this->categories
        ]);
    }
    /**
     * display view create
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('internal.create', [ "categories" => $this->categories ]);
    }

    /**
     * store instance to database
     * @method post
     * @param InternalSpecRequest $request
     * @return mixed|string
     */
    public function store(InternalSpecRequest $request) {
        try {
            if (CompanySpec::isExist($request)) throw new DuplicateEntryException("Company Specification already exist!");

            $this->factory->store(new InternalSpecification, $request);
            return redirect(route("internal.index"));
        } catch(DuplicateEntryException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param CompanySpec $internal
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(CompanySpec $internal) {
        $document = new Document($internal->companySpecRevision->document);
        return $document->showPDF();
    }

    /**
     * display view edit
     * @param CompanySpec $internal
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param CompanySpec $companySpec
     */
    public function edit(CompanySpec $internal) {
        return view('internal.edit', ['spec' => $internal, "categories" => $this->categories ]);
    }

    /**
     * update database
     * @method patch
     * @param InternalSpecRequest $request
     * @param CompanySpec $internal
     * @return mixed
     * @internal param CompanySpec $companySpec
     */
    public function update(InternalSpecRequest $request, CompanySpec $internal) {
        $this->factory->update(new InternalSpecification($internal), $request);
        return redirect(route("internal.index"));
    }

    /**
     * delete database instance
     * @param CompanySpec $internal
     * @return mixed
     * @internal param CompanySpec $companySpec
     */
    public function destroy(CompanySpec $internal) {
        $internal->delete();
    }
}
