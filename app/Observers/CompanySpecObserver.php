<?php namespace App\Observers;

use App\CompanySpec;
use Illuminate\Support\Facades\Mail;

class CompanySpecObserver
{
    /**
     * Listen to the document created event.
     */
    public function created() {
        flash("Document save to the database!.","success");
    }

    /**
     * @param CompanySpec $spec
     */
    public function updated(CompanySpec $spec)
    {
        flash("Database successfully updated!.","success");
    }
}