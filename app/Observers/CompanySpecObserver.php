<?php namespace App\Observers;

class CompanySpecObserver
{
    /**
     * Listen to the document created event.
     */
    public function created() {
        flash("Document save to the database!.","success");
    }

    public function updated()
    {
        flash("Database successfully updated!.","success");
    }

    /**
     * Listen to the User deleting event.
     */
    public function deleted()
    {
        flash("Document successfully deleted to database!.","success");
    }
}