<?php namespace App\DCC\External\Store;

use App\DCC\Traits\RequestSetter;
use App\DCC\Traits\SpecSetterGetter;

abstract class AddAbstract implements AddInterface
{
    use SpecSetterGetter, RequestSetter;
}