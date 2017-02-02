<?php namespace App\DCC\Internal;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\DCC\Exceptions\SpecNotFoundException;
use App\DCC\SpecificationGateway;
use Illuminate\Http\Request;

class InternalSpecCategory implements SpecificationGateway {
    private $spec;
    private $request;

    public function __construct(Request $request, CompanySpec $spec=null) {
        $this->spec = $spec;
        $this->request = $request;
    }

    function persist() {
        $category = $this->request->category == 'add_category' // if true means insert new category
            ? CompanySpecCategory::instance($this->request)
            : CompanySpecCategory::whereCategoryNo($this->request->category)->first()->toArray();

        return $this->spec->companySpecCategory()->firstOrCreate($category);
    }

    function update() {
        if ($this->spec === null) throw new SpecNotFoundException();
        $this->spec->companySpecCategory()->update(CompanySpecCategory::instance($this->request));
    }
}