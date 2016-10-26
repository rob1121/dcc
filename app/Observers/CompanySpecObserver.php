<?php namespace App\Observers;

use App\CompanySpec;

class CompanySpecObserver
{
    /**
     * Listen to the document created event.
     */
    public function created() {
        flash("Document save to the database!.","success");
    }

    /*
     * @param CompanySpec $spec
     */
    public function saved()
    {
        flash("Database successfully updated!.","success");
    }
}