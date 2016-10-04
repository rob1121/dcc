<?php

namespace App\Listeners;

use App\Events\SomeEvent;
use App\Notifications\InternalSpecUpdateNotifier;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventListener implements ShouldQueue {
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SomeEvent  $event
     * @return void
     */
    public function handle(SomeEvent $event)
    {
        \Auth::user()->notify(new InternalSpecUpdateNotifier($event->spec));
    }
}
