<?php namespace App\Dcc\Traits\Presenter;


trait InternalSpecPresenter
{

    public function getSpecIdAttribute()
    {
        return $this->companySpecCategory->category_no . " - " . sprintf("%d03", $this->spec_no);
    }

    public function getSpecNameAttribute()
    {
        return \Str::upper($this->spec_id) . ' - ' . \Str::title($this->name);
    }

    public function getOriginatorDepartmentsAttribute()
    {
        return $this->originator->map( function( $origin ) {
            return $origin->department;
        } )->toArray();
    }
}