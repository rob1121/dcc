<?php namespace App\Listeners;

use Illuminate\Support\Facades\Request;

class UserEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function onUserLogin() {
        activity()
            ->withProperties(['ip' => Request::ip()])
            ->log("user is logged in");
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout() {
        activity()
            ->withProperties(['ip' => Request::ip()])
            ->log("user is logged out");
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