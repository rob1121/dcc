<?php namespace App\Dcc\Traits\Presenter;


trait InternalSpecCategoryPresenter
{
    public function getCategoryTitleAttribute()
    {
        return \Str::upper($this->category_no) . ' - ' . \Str::title($this->category_name);
    }
}