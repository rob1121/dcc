<?php namespace App\DCC\Company;

use App\CompanySpec;
use App\CompanySpecCategory;
use App\CompanySpecRevision;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class ValidationRules
{
    use ValidatesRequests;

    /**
     * validate specification
     * @param Request $request
     */
    public function validateSpec(Request $request)
    {
        $this->validate($request, $this->validationRules());
    }

    /**
     * validation rules
     * @return array
     */
    private function validationRules()
    {
        return collect(CompanySpec::RULES)
            ->merge(CompanySpecRevision::RULES)
            ->merge(CompanySpecCategory::RULES)
            ->toArray();
    }

}