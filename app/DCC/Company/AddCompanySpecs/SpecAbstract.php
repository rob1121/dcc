<?php namespace App\DCC\Company\AddCompanySpecs;

abstract class SpecAbstract implements AddCompanySpecsInterface
{
    protected $spec;
    protected $request;

    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function setSpec($spec)
    {
        $this->spec = $spec;
    }

    public function getSpec()
    {
        return $this->spec;
    }


}