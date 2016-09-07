<?php namespace App\DCC\Company\UpdateCompanySpecs;

use App\DCC\Traits\RequestSetter;
use App\DCC\Traits\SpecSetterGetter;

Abstract class UpdateSpecAbstract implements UpdateSpecsInterface
{
    use SpecSetterGetter, RequestSetter;
}