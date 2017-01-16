<?php namespace App\Http\Controllers;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\DCC\Exceptions\DuplicateEntryException;
use App\DCC\File\Document;
use App\DCC\Internal\InternalSpecification;
use App\DCC\SpecificationFactory;
use App\Department;
use App\Events\Internal\Delete;
use App\Events\Internal\Show;
use App\Events\Internal\Store;
use App\Events\Internal\Update;
use App\Http\Requests\InternalSpecRequest;
use ErrorException;
use Illuminate\Support\Facades\Event;

class InternalController extends Controller {
    private $factory;
    private $categories;

    function __construct() {
        $this->middleware("auth", ["except" => ["index","show"]]);
        $this->middleware("auth.admin", ["only" => ["create","store","edit","update","destroy"]]);
        $this->middleware("server_push",["only" => ["index","edit","show","create"]]);

        $this->factory = new SpecificationFactory;
        $this->categories = CompanySpecCategory::getCategoryList();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index() {
        return view('internal.index', [
            "categories" => $this->categories
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function create() {
        return view('internal.create', [
            "category_lists"    => $this->categories,
            "departments"   => Department::listDepartments()
        ]);
    }

    /**
     * @param InternalSpecRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function store(InternalSpecRequest $request) {
        try {
            if (CompanySpec::isExist($request)) throw new DuplicateEntryException();

            $internal = $this->factory->store(new InternalSpecification($request));
            Event::fire(new Store($internal));
            return redirect(route("internal.index"));
        } catch(DuplicateEntryException $e) {
            flash("{$request->spec_no} {$request->name} already exist!.","danger");
            return redirect()->back();
        }
    }

    /**
     * @param CompanySpec $internal
     * @return mixed
     */
    function show(CompanySpec $internal) {
        try {
            $pdf = (new Document($internal->companySpecRevision->document))->showPDF();
            Event::fire(new Show($internal));
            return $pdf;
        } catch (ErrorException $e) {
            abort(406,"Specification not found in the database");
        }
    }

    /**
     * @param CompanySpec $internal
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function edit(CompanySpec $internal) {
        return view('internal.edit', [
            'spec'          => $internal,
            "departments"   => Department::listDepartments()
        ]);
    }

    /**
     * @param InternalSpecRequest $request
     * @param CompanySpec $internal
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function update(InternalSpecRequest $request, CompanySpec $internal) {
        $this->factory->update(new InternalSpecification($request, $internal));
        Event::fire(new Update($internal));
        return redirect()->route("internal.index");
    }

    /**
     * @param CompanySpec $internal
     */
    function destroy(CompanySpec $internal) {
        $internal->delete();
        Event::fire(new Delete($internal->name));
    }
}
