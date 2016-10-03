<?php namespace App\Http\Controllers;

use App\CustomerSpec;
use App\CustomerSpecCategory;
use App\CustomerSpecRevision;
use App\DCC\Exceptions\DuplicateEntryException;
use App\DCC\Exceptions\SpecNotFoundException;
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
        $this->middleware("server_push",["only" => ["index","edit","show","create"]]);
        $this->factory = new SpecificationFactory;
        $this->categories = CustomerSpecCategory::customerList();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        \JavaScript::put('category', $first_category = $this->categories->first());

        return view('external.index', [ "categories" => $this->categories ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('external.create', [
            "categories" => $this->categories,
            "reviewers_list" => CustomerSpecRevision::uniqueReviewer()
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
            flash("document already exist!.","danger");
            return redirect()->back();
        }
    }

    /**
     * @param CustomerSpec $external
     * @param null $revision
     * @return mixed
     * @throws SpecNotFoundException
     */
    public function show(CustomerSpec $external, $revision=null) {
        try { return (new Document($this->getSpec($external, $revision)))->showPDF(); }
        catch (ErrorException $e) { throw new SpecNotFoundException("External Specification not found in the database"); }
    }

    /**
     * @param CustomerSpec $external
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(CustomerSpec $external) {
        return view("external.edit", [ "spec" => $external, "categories" => $this->categories ]);
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
            ? $external->customerSpecRevision()->whereRevision($revision)->first()->document
            : $external->customerSpecRevision()->orderBy('revision', 'desc')->first()->document;
    }
}
