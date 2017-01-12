<?php namespace App\Dcc\Traits\Presenter;


trait ESDPresenter
{
    public function getTitleAttribute()
    {
        return \Str::upper($this->spec_no . ' - ' . $this->name);
    }

    public function getEsdShowAttribute()
    {
        return route("esd.show", ["esd" => $this->id]);
    }

    public function getEsdEditAttribute()
    {
        return route("esd.edit", ["esd" => $this->id]);
    }

}