<?php namespace App\DCC\Company\AddCompanySpecs;

interface AddCompanySpecsInterface
{
    public function add();

    public function setRequest($request);

    public function setSpec($spec);

    public function getSpec();
}