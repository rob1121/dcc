<?php namespace App\Listeners;


use App\User;

class InternalSpecEventSubscriber {

    public function onShow() {
        activity()->log("user is logged in");
    }
    
    public function onDelete() {
        activity()->log("user is logged in");
    }

    public function onStore() {
        activity()->log("user is logged out");
    }

    public function onUpdate() {
        activity()->log("user is logged out");
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events) {
        $events->listen(
            'App\Events\Internal\Show',
            'App\Listeners\InternalSpecEventSubscriber@onShow'
        );

        $events->listen(
            'App\Events\Internal\Delete',
            'App\Listeners\InternalSpecEventSubscriber@onDelete'
        );

        $events->listen(
            'App\Events\Internal\Store',
            'App\Listeners\InternalSpecEventSubscriber@onStore'
        );

        $events->listen(
            'App\Events\Internal\Update',
            'App\Listeners\InternalSpecEventSubscriber@onUpdate'
        );
    }
}