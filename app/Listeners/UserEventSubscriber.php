<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class UserEventSubscriber
{
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
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onLogin'
        );
    }

    /**
     * Handle the event onLogin.
     *
     * @param  $event  $event
     * @return void
     */
    public function onLogin($event)
    {
       Log::info('Execute onLogin.');
	   $user = $event->user;
       $user->last_login_at = date('Y-m-d H:i:s');
       $user->save();
	   Log::info('End onLogin.');
    }
}
