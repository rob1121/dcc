<?php namespace App\Dcc\Traits\Presenter;

trait ExternalSpecPresenter
{
    public function getSpecNameAttribute()
    {
        return \Str::upper($this->spec_no . " - " . $this->name);
    }

    public function getLatestRevisionAttribute()
    {
        return \Str::upper($this->customerSpecRevision->sortBy("revision")->last()->revision);
    }

    public function getLatestRevisionDateAttribute()
    {
        return \Str::upper($this->customerSpecRevision->sortBy("revision")->last()->revision_date);
    }
}