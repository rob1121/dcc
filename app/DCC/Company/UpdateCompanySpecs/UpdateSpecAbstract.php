<?php namespace App\DCC\Company\UpdateCompanySpecs;

Abstract class UpdateSpecAbstract implements UpdateSpecsInterface
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