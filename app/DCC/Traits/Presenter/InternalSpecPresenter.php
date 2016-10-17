<?php namespace App\Dcc\Traits\Presenter;


trait InternalSpecPresenter
{
    public function getSpecNameAttribute()
    {
        return $this->spec_no . ' - ' . $this->name;
    }
}