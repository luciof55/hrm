<?php

namespace App\Listeners;

use App\Events\BusinessRecordUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class BusinessRecordEventSubscriber
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
            'App\Events\BusinessRecordUpdateEvent',
            'App\Listeners\BusinessRecordEventSubscriber@onBusinessRecordUpdate'
        );
		
		 $events->listen(
            'App\Events\BusinessRecordCreateEvent',
            'App\Listeners\BusinessRecordEventSubscriber@onBusinessRecordCreate'
        );

    }

    /**
     * Handle the event onBusinessRecordUpdate.
     *
     * @param  BusinessRecordUpdated  $event
     * @return void
     */
    public function onBusinessRecordUpdate(\App\Events\BusinessRecordUpdateEvent $event)
    {
       Log::info('Execute onBusinessRecordUpdate.');
	   Log::info('BusinessRecord: '.$event->getBusinessRecord()->name);
	   $event->getBusinessRecord();
	   Log::info('End onBusinessRecordUpdate.');
    }
	
	/**
     * Handle the event onBusinessRecordCreate.
     *
     * @param  BusinessRecordUpdated  $event
     * @return void
     */
    public function onBusinessRecordCreate(\App\Events\BusinessRecordCreateEvent $event)
    {
       Log::info('Execute onBusinessRecordCreate.');
	   Log::info('BusinessRecord: '.$event->getBusinessRecord()->name);
	   $event->getBusinessRecord();
	   Log::info('End onBusinessRecordCreate.');
    }
}
