<?php namespace App\Listeners;


use Illuminate\Support\Facades\Request;

class ISOEventSubscriber
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
            'App\Events\ISO\Show',
            'App\Listeners\ISOEventSubscriber@onShow'
        );

        $events->listen(
            'App\Events\ISO\Delete',
            'App\Listeners\ISOEventSubscriber@onDelete'
        );

        $events->listen(
            'App\Events\ISO\Store',
            'App\Listeners\ISOEventSubscriber@onStore'
        );

        $events->listen(
            'App\Events\ISO\Update',
            'App\Listeners\ISOEventSubscriber@onUpdate'
        );
    }
}