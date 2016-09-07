<?php namespace App\DCC\Company\AddCompanySpecs;

use App\DCC\Traits\RequestSetter;
use App\DCC\Traits\SpecSetterGetter;

abstract class SpecAbstract implements AddCompanySpecsInterface
{
    use SpecSetterGetter, RequestSetter;
}