<?php namespace App\Http\Controllers;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\DCC\Exceptions\DuplicateEntryException;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\File\Document;
use App\DCC\Internal\InternalSpecification;
use App\DCC\SpecificationFactory;
use App\Http\Requests\InternalSpecRequest;
use ErrorException;

class InternalController extends Controller {
    private $factory;
    private $categories;

    public function __construct() {
        $this->middleware("auth", ["only" => ["create","store","edit","update","destroy"]]);
        $this->middleware("server_push",["only" => ["index","edit","show","create"]]);
        $this->factory = new SpecificationFactory;
        $this->categories = CompanySpecCategory::getCategoryList();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        \JavaScript::put('category', $this->categories->first());

        return view('internal.index', [ "categories" => $this->categories ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('internal.create', [ "categories" => $this->categories ]);
    }

    /**
     * @param InternalSpecRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(InternalSpecRequest $request) {
        try {
            if (CompanySpec::isExist($request)) throw new DuplicateEntryException("Company Specification already exist!");

            $this->factory->store(new InternalSpecification($request));
            return redirect(route("internal.index"));
        } catch(DuplicateEntryException $e) {
            flash("document already exist!.","danger");
            return redirect()->back();
        }
    }

    /**
     * @param CompanySpec $internal
     * @return mixed
     * @throws SpecNotFoundException
     */
    public function show(CompanySpec $internal) {
        try { return (new Document($internal->companySpecRevision->document))->showPDF(); }
        catch (ErrorException $e) { throw new SpecNotFoundException("External Specification not found in the database"); }
    }

    /**
     * @param CompanySpec $internal
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(CompanySpec $internal) {
        return view('internal.edit', ['spec' => $internal, "categories" => $this->categories ]);
    }

    /**
     * @param InternalSpecRequest $request
     * @param CompanySpec $internal
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(InternalSpecRequest $request, CompanySpec $internal) {
        $this->factory->update(new InternalSpecification($request, $internal));
        return redirect(route("internal.index"));
    }

    /**
     * @param CompanySpec $internal
     */
    public function destroy(CompanySpec $internal) {
        $internal->delete();
    }
}
