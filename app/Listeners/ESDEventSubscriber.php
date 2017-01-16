<?php namespace App\Listeners;


use Illuminate\Support\Facades\Request;

class ESDEventSubscriber
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
            'App\Events\ESD\Show',
            'App\Listeners\ESDEventSubscriber@onShow'
        );

        $events->listen(
            'App\Events\ESD\Delete',
            'App\Listeners\ESDEventSubscriber@onDelete'
        );

        $events->listen(
            'App\Events\ESD\Store',
            'App\Listeners\ESDEventSubscriber@onStore'
        );

        $events->listen(
            'App\Events\ESD\Update',
            'App\Listeners\ESDEventSubscriber@onUpdate'
        );
    }

}