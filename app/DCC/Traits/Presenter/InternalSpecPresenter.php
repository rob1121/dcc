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

    public function getInternalShowAttribute()
    {
        return route("internal.show", ["internal" => $this->id]);
    }

    public function getInternalDestroyAttribute()
    {
        return route("internal.destroy", ["internal" => $this->id]);
    }

    public function getRevisionSummaryAttribute()
    {
        return str_limit($this->companySpecRevision->revision_summary, 50);
    }

    public function getHighlightAttribute()
    {
        return $this->companySpecRevision->revision_date > \Carbon::now()->subDays(7)
            ? "new revision"
            : "";
    }
}