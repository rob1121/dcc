<?php namespace App\Dcc\Traits\Presenter;


trait InternalSpecPresenter
{
    public function getSpecNameAttribute()
    {
        return \Str::upper($this->spec_no) . ' - ' . \Str::title($this->name);
    }

    public function getOriginatorDepartmentsAttribute()
    {
        return $this->originator->map( function( $origin ) {
            return $origin->department;
        } )->toArray();
    }
}