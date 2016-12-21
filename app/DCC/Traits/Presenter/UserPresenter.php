<?php namespace App\Dcc\Traits\Presenter;


trait UserPresenter
{


    public function setEmployeeIdAttribute($value)
    {
        $this->attributes['employee_id'] = trim($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = trim($value);
    }

    public function setUserTypeAttribute($value)
    {
        $this->attributes['user_type'] = trim($value);
    }

    public function getEditRouteAttribute()
    {
        return route('user.edit',['user' => $this->id]);
    }

    public function getDeleteRouteAttribute()
    {
        return route('user.delete', ['user' => $this->id]);
    }

    public function getDepartmentsAttribute()
    {
        return $this->department->pluck('department');
    }
}