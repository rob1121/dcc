<?php namespace App\Http\Controllers;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\CompanySpecRevision;
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $category_with_new_revisions = CompanySpecRevision::countOfNewRevision();

        $this->categories = $this->categories->map(function($item) use ($category_with_new_revisions) {
                return [
                    "category_no" => $item->category_no,
                    "category_name" => $item->category_name,
                    "count" => $category_with_new_revisions->where("category_no",$item->category_no)->count()
                ];

        });

        JavaScript::put('category', $this->categories->first());

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
            flash("document save to the database!.","success");
            return redirect(route("internal.index"));
        } catch(DuplicateEntryException $e) {
            flash("document already exist!.","danger");
            return redirect()->back();
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
        flash("Database successfully updated!.","success");
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
