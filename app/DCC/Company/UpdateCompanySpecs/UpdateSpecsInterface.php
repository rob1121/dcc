<?php namespace App\DCC\Company\UpdateCompanySpecs;


interface UpdateSpecsInterface
{
    public function update();

    public function setRequest($request);

    public function getSpec();

    public function setSpec($spec);
}