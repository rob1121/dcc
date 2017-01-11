<?php namespace App\Observers;

class IsoObserver
{
    /**
     * Listen to the document created event.
     */
    public function created() {
        flash("Document save to the database!.","success");
    }
    
    public function saved() {
        flash("Database successfully updated!.","success");
    }
}