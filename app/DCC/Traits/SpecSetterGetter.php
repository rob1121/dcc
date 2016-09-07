<?php namespace App\DCC\Traits;


trait SpecSetterGetter
{
    protected $spec;

    public function setSpec($spec)
    {
        $this->spec = $spec;
    }

    public function getSpec()
    {
        return $this->spec;
    }

}