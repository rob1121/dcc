<?php namespace App\Http\Controllers;

use App\CustomerSpec;
use App\CustomerSpecCategory;
use App\DCC\External\ExternalSpecification;
use App\DCC\File\Document;
use App\DCC\SpecificationFactory;
use App\Http\Requests\ExternalSpecRequest;
use ErrorException;
use Illuminate\Http\Request;
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
        JavaScript::put('category', $first_category = $this->categories->first());

        return view('external.index', [ "categories" => $categories ]);
    }

    public function getCustomerSpecForReviewCountPerCategory($customer_name)
    {
        $a = CustomerSpecCategory::whereCustomerName($customer_name)->with(["customerSpec" => function($query) {
            $query->with("customerSpecRevision");
        }])->get()
            ->map(function ($item) {
                return $item->customerSpec->customerSpecRevision->where("is_reviewed",0)->count();
            })->sum();
        return $a;
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
        try {
            $document = $this->getSpec($external, $revision);
            return (new Document($document))->showPDF();
        } catch (ErrorException $e) {
            return "External Specification not found in the database";
        }
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
     * update customer specs revision through ajax request
     *
     * @param ExternalSpecRequest $request
     * @param CustomerSpec $external
     */
    public function updateRevision(ExternalSpecRequest $request, CustomerSpec $external) {
        $external->customerSpecRevision()->whereRevision($request->revision)->update(["is_reviewed" => $request->is_reviewed]);
    }

    /**
     * Remove the specified resource from storage.
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
    protected function getSpec(CustomerSpec $external, $revision)
    {
        $document = $revision
            ? $external->customerSpecRevision()->whereRevision($revision)->first()->document
            : $external->customerSpecRevision()->orderBy('revision', 'desc')->first()->document;
        return $document;
    }
}
