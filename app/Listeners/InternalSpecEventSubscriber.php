<?php namespace App\Listeners;

use Illuminate\Support\Facades\Request;

class InternalSpecEventSubscriber
{

    public function onShow($event) {
        activity()->on($event->spec)
            ->withProperties(['ip' => Request::ip()])
            ->log("view");
    }

    public function onDelete($event) {
        activity()->withProperties(['ip' => Request::ip()])
            ->log("delete {$event->spec_title}");
    }

    public function onStore($event) {
        activity()->on($event->spec)
            ->withProperties(['ip' => Request::ip()])
            ->log("create");
    }

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