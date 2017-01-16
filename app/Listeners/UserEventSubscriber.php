<?php namespace App\Listeners;

use Illuminate\Support\Facades\Request;

class UserEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function onUserLogin() {
        activity()->withProperties(['ip' => Request::ip()])
            ->log("logged in");
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout() {
        activity()->withProperties(['ip' => Request::ip()])
            ->log("logged out");
    }

    /**
     * Handle user logout events.
     */
    public function onDelete($event) {
        activity()->withProperties(['ip' => Request::ip()])
            ->log("delete {$event->name}");
    }

    /**
     * Handle user logout events.
     */
    public function onCreate($event) {
        activity()->on($event->spec)
            ->withProperties(['ip' => Request::ip()])
            ->log("create");
    }

    /**
     * Handle user logout events.
     */
    public function onUpdate($event) {
        activity()->on($event->spec)
            ->withProperties(['ip' => Request::ip()])
            ->log("update");
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

        $events->listen(
            'App\Events\Delete',
            'App\Listeners\UserEventSubscriber@onDelete'
        );

        $events->listen(
            'App\Events\Create',
            'App\Listeners\UserEventSubscriber@onCreate'
        );

        $events->listen(
            'App\Events\Update',
            'App\Listeners\UserEventSubscriber@onUpdate'
        );
    }
}