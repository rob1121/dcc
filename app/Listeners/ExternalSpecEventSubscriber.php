<?php namespace App\Listeners;

use Illuminate\Support\Facades\Request;

class ExternalSpecEventSubscriber
{
    public function onShow($event) {
        activity()->on($event->spec)
            ->withProperties(['ip' => Request::ip()])
            ->log("view");
    }

    public function onDelete($event) {
        activity()->on($event->spec)
            ->withProperties(['ip' => Request::ip()])
            ->log("delete");
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

    public function onReview($event) {
        activity()->on($event->spec)
            ->withProperties(['ip' => Request::ip()])
            ->log("mark as reviewed");
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events) {
        $events->listen(
            'App\Events\External\Show',
            'App\Listeners\ExternalSpecEventSubscriber@onShow'
        );

        $events->listen(
            'App\Events\External\Delete',
            'App\Listeners\ExternalSpecEventSubscriber@onDelete'
        );

        $events->listen(
            'App\Events\External\Store',
            'App\Listeners\ExternalSpecEventSubscriber@onStore'
        );

        $events->listen(
            'App\Events\External\Update',
            'App\Listeners\ExternalSpecEventSubscriber@onUpdate'
        );

        $events->listen(
            'App\Events\External\Review',
            'App\Listeners\ExternalSpecEventSubscriber@onReview'
        );
    }

}