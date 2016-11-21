<?php namespace App\Http\Controllers;

use App\CustomerSpec;
use App\CustomerSpecCategory;
use App\DCC\Exceptions\DuplicateEntryException;
use App\DCC\External\ExternalSpecification;
use App\DCC\File\Document;
use App\DCC\SpecificationFactory;
use App\Http\Requests\ExternalSpecRequest;
use ErrorException;

class ExternalController extends Controller {
    private $factory;
    private $categories;

    public function __construct()
    {
        $this->middleware("auth");
        $this->middleware("auth.admin", ["only" => ["create","store","edit","update","destroy"]]);
        $this->middleware("server_push",["only" => ["index","edit","show","create"]]);
        $this->factory = new SpecificationFactory;
        $this->categories = CustomerSpecCategory::getCategoryList();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('external.index', [
            "categories" => $this->categories
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('external.create', [
            "category_lists" => $this->categories,
            "reviewers_list" => CustomerSpec::uniqueReviewer()
        ]);
    }

    /**
     * @param ExternalSpecRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ExternalSpecRequest $request) {
        try {
            if (CustomerSpec::isExist($request)) throw new DuplicateEntryException("Company Specification already exist!");

            $this->factory->store(new ExternalSpecification($request));
            return redirect()->route("external.index");
        } catch(DuplicateEntryException $e) {
            flash("{$request->spec_no} {$request->name} document already exist!.","danger");
            return redirect()->back();
        }
    }

    /**
     * @param CustomerSpec $external
     * @param null $revision
     * @return mixed
     */
    public function show(CustomerSpec $external, $revision=null)
    {
        try
        {
            $doc = $this->getSpec($external, $revision);
            if($doc->is_reviewed && $revision !== null) abort(407,"Spec you are trying to view is already reviewed");
            return (new Document($doc->document))->showPDF();

        } catch (ErrorException $e) { abort(406,"External Specification not found in the database"); }
    }

    /**
     * @param CustomerSpec $external
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(CustomerSpec $external) {
        return view("external.edit", [
            "spec" => $external, "category_lists" => $this->categories, "reviewers_list" => CustomerSpec::uniqueReviewer()
        ]);
    }

    /**
     * @param ExternalSpecRequest $request
     * @param CustomerSpec $external
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ExternalSpecRequest $request, CustomerSpec $external) {
        $this->factory->update(new ExternalSpecification($request, $external));
        return redirect()->route("external.index");
    }

    /**
     * @param ExternalSpecRequest $request
     * @param CustomerSpec $external
     */
    public function updateRevision(ExternalSpecRequest $request, CustomerSpec $external) {
        $external->customerSpecRevision()->whereRevision($request->revision)
            ->update(["is_reviewed" => $request->is_reviewed]);
    }

    /**
     * @param CustomerSpec $external
     */
    public function destroy(CustomerSpec $external) {
        $external->delete();
    }

    /**
     * @param CustomerSpec $external
     * @param $revision
     * @return mixed
     */
    protected function getSpec(CustomerSpec $external, $revision) {
        return $revision
            ? $external->customerSpecRevision()->whereRevision($revision)->first()
            : $external->customerSpecRevision()->orderBy('revision', 'desc')->first();
    }
}
