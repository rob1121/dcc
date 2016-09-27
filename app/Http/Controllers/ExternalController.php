<?php namespace App\Http\Controllers;

use App\CustomerSpec;
use App\CustomerSpecCategory;
use App\CustomerSpecRevision;
use App\DCC\External\ExternalSpecification;
use App\DCC\File\Document;
use App\DCC\SpecificationFactory;
use App\Http\Requests\ExternalSpecRequest;
use JavaScript;

class ExternalController extends Controller {
    private $factory;
    private $categories;

    public function __construct() {
        $this->factory = new SpecificationFactory;
        $this->categories = CustomerSpecCategory::customerList();
    }

    public function index() {
        $categories = $this->categories->map(function($category) {
            return [
                "count" => $this->getCustomerSpecForReviewCountPerCategory($category->customer_name),
                "customer_name" => $category->customer_name
            ];
        });
        JavaScript::put([ 'customer_name' => $this->categories->first()->customer_name ]);

        return view('external.index', [ "categories" => $categories ]);
    }

    public function getCustomerSpecForReviewCountPerCategory($customer_name)
    {
        return CustomerSpecCategory::whereCustomerName($customer_name)->get()
            ->map(function ($item) {
                return CustomerSpecRevision::whereCustomerSpecId($item->customer_spec_id)
                    ->whereIsReviewed(0)
                    ->count();
            })->sum();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('external.create', [ "categories" => $this->categories ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExternalSpecRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExternalSpecRequest $request) {
        $this->factory->store(new ExternalSpecification, $request);
        return redirect(route("external.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param CustomerSpec $external
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(CustomerSpec $external, $revision=null) {
        $document = $revision
            ? $external->customerSpecRevision()->whereRevision($revision)->first()->document
            : $external->customerSpecRevision()->orderBy('revision','desc')->first()->document;

        $document = new Document($document);
        return $document->showPDF();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CustomerSpec $external
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerSpec $external) {
        return view("external.edit", [ "spec" => $external, "categories" => $this->categories ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExternalSpecRequest $request
     * @param CustomerSpec $external
     * @return \Illuminate\Http\Response
     */
    public function update(ExternalSpecRequest $request, CustomerSpec $external) {
        $this->factory->update(new ExternalSpecification($external), $request);
        return redirect(route("external.index"));
    }

    /**
     * Remove the specified resource from storage.
     * @param CustomerSpec $external
     */
    public function destroy(CustomerSpec $external) {
        $external->delete();
    }
}
