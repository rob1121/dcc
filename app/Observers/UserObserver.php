<?php namespace App\Observers;

class UserObserver
{
    /**
     * Listen to the User created event.
     *
     */
    public function created() {
        flash("User successfully added to database!.","success");
    }

    /**
     * Listen to the User deleting event.
     *
     */
    public function deleted() {
        flash("User successfully deleted to database!.","success");
    }
}