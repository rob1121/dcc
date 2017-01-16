<?php namespace App\Http\Controllers;

use App\CustomerSpec;
use App\CustomerSpecCategory;
use App\DCC\Exceptions\DuplicateEntryException;
use App\DCC\External\ExternalSpecification;
use App\DCC\File\Document;
use App\DCC\SpecificationFactory;
use App\Department;
use App\Events\External\Delete;
use App\Events\External\Review;
use App\Events\External\Show;
use App\Events\External\Store;
use App\Events\External\Update;
use App\Http\Requests\ExternalSpecRequest;
use ErrorException;
use Illuminate\Support\Facades\Event;

class ExternalController extends Controller {
    private $factory;
    private $categories;

    function __construct()
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
    function index() {
        return view('external.index', [
            "categories" => $this->categories
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function create() {
        return view('external.create', [
            "category_lists" => $this->categories,
            "reviewers_list" => CustomerSpec::uniqueReviewer()
        ]);
    }

    /**
     * @param ExternalSpecRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function store(ExternalSpecRequest $request) {
        try {
            if (CustomerSpec::isExist($request)) throw new DuplicateEntryException("Company Specification already exist!");

            $external = $this->factory->store(new ExternalSpecification($request));
            Event::fire(new Store($external));
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
    function show(CustomerSpec $external, $revision=null)
    {
        try
        {
            $doc = $this->getSpec($external, $revision);
            if($doc->is_reviewed && $revision !== null) abort(407,"Spec you are trying to view is already reviewed");

            Event::fire(new Show($external));
            return (new Document($doc->document))->showPDF();

        } catch (ErrorException $e) { abort(406,"External Specification not found in the database"); }
    }

    /**
     * @param CustomerSpec $external
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function edit(CustomerSpec $external) {
        return view("external.edit", [
            "spec" => $external,
            "category_lists" => $this->categories,
            "reviewers_list" => CustomerSpec::uniqueReviewer(),
            "departments" => Department::listDepartments()
        ]);
    }

    /**
     * @param ExternalSpecRequest $request
     * @param CustomerSpec $external
     * @return \Illuminate\Http\RedirectResponse
     */
    function update(ExternalSpecRequest $request, CustomerSpec $external) {
        $this->factory->update(new ExternalSpecification($request, $external));
        Event::fire(new Update($external));
        return redirect()->route("external.index");
    }

    /**
     * @param ExternalSpecRequest $request
     * @param CustomerSpec $external
     */
    function updateRevision(ExternalSpecRequest $request, CustomerSpec $external) {
        $external->customerSpecRevision()->whereRevision($request->revision)
            ->update(["is_reviewed" => $request->is_reviewed]);

        Event::fire(new Review($external));
    }

    /**
     * @param CustomerSpec $external
     */
    function destroy(CustomerSpec $external) {
        $external->delete();
        Event::fire(new Delete($external->name));
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
