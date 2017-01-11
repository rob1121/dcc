<?php namespace App\Observers;

class CompanySpecObserver
{
    /**
     * Listen to the document created event.
     */
    public function created() {
        flash("Document save to the database!.","success");
    }

    /*
     */
    public function saved() {
        flash("Database successfully updated!.","success");
    }
}