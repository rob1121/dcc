<?php namespace App\DCC\AddCompanySpecs;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class ValidateRequest
{
    use ValidatesRequests;
    /**
     * @var Request
     */
    private $request;
    private $rules;

    /**
     * @param $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * set rules
     * @param $rules
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    /**
     * validate request
     */
    public function validate()
    {
        $this->validate($this->request, $this->rules);
    }
}