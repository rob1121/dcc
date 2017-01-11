<?php namespace App\Observers;

class UserObserver {
    /**
     * Listen to the User created event.
     */
    function created() {
        flash("User successfully added to database!.","success");
    }

    /**
     */
    function saved() {
//        Log::info("{$this->user->name} added new external specification {$user->name}");
        flash("User Database successfully updated!.","success");
    }
}