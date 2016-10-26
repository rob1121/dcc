<?php namespace App\Dcc\Traits\Presenter;
trait IsoPresenter
{
    public function getTitleAttribute()
    {
        return \Str::upper($this->spec_no . ' - ' . $this->name);
    }

    public function getIsoShowAttribute()
    {
        return route("iso.show", ["iso" => $this->id]);
    }

    public function getIsoEditAttribute()
    {
        return route("iso.edit", ["iso" => $this->id]);
    }
}