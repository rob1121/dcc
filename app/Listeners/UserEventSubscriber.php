<?php namespace App\Listeners;

class UserEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function onUserLogin() {
        activity()->log("user is logged in");
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout() {
        activity()->log("user is logged out");
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events) {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );
    }
}