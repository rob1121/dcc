<?php namespace App\Observers;

class CustomerSpecObserver
{
    /**
     * Listen to the document created event.
     */
    public function created() {
        flash("Document save to the database!.","success");
    }

    /**
     * Listen to the Document updated event.
     */
    public function saved()
    {
        flash("Database successfully updated!.","success");
    }

}