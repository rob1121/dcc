<?php namespace App\Dcc\Traits\Presenter;


use Str;

trait InternalSpecPresenter
{
    /**
     * @return string
     */
    function getSpecIdAttribute() {
        return $this->companySpecCategory->category_no . " - " . sprintf("%03d", $this->spec_no);
    }

    /**
     * @return string
     */
    function getSpecNameAttribute() {
        return Str::upper($this->spec_id) . ' - ' . Str::title($this->name);
    }

    /**
     * @return mixed
     */
    function getOriginatorDepartmentsAttribute() {
        return $this->originator->pluck('department')->toArray();
    }

    /**
     * @return string
     */
    function getInternalShowAttribute() {
        return route("internal.show", ["internal" => $this->id]);
    }

    /**
     * @return string
     */
    function getInternalDestroyAttribute() {
        return route("internal.destroy", ["internal" => $this->id]);
    }

    /**
     * @return string
     */
    function getInternalEditAttribute() {
        return route("internal.edit", ["internal" => $this->id]);
    }

    /**
     * @return string
     */
    function getRevisionSummaryAttribute() {
        return str_limit($this->companySpecRevision->revision_summary, 50);
    }

    /**
     * @return string
     */
    function getHighlightAttribute() {
        return $this->companySpecRevision->revision_date > \Carbon::now()->subDays(7)
            ? "new revision"
            : "";
    }

    /**
     * @return mixed
     */
    function getCcEmailAttribute() {
        return $this->cc->pluck('email')->toArray();
    }
}