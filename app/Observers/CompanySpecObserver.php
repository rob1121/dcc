<?php namespace App\Observers;

use App\CompanySpec;
use App\Jobs\NotifyUserForSpecUpdate;
use App\Notifications\InternalSpecUpdateNotifier;
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
        Mail::to('robinsonlegaspi@astigp.com')->send(new \App\Mail\MailUpdatedSpecs());
//        dispatch(new NotifyUserForSpecUpdate($spec));
//        if(\Auth::user()) \Auth::user()->notify(new InternalSpecUpdateNotifier($spec));
    }

    /**
     * Listen to the User deleting event.
     */
    public function deleted()
    {
        flash("Document successfully deleted to database!.","success");
    }
}