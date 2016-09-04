<?php namespace App\DCC\AddCompanySpecs;

interface AddCompanySpecsInterface
{
    public function validateSpec();

    public function add();

    public function getResult();
}