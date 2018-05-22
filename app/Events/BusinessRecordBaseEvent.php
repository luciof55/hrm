<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Model\BusinessRecord;

class BusinessRecordBaseEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
	
	protected $businessRecord;

	public function getBusinessRecord() {
			return $this->businessRecord;
	}
	
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Model\Administration\BusinessRecord $businessRecord)
    {
        $this->businessRecord = $businessRecord;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
