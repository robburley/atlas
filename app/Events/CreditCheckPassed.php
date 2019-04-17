<?php

namespace App\Events;

use App\Models\MobileOpportunity\MobileOpportunity;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreditCheckPassed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $opportunity;

    /**
     * Create a new event instance.
     *
     * @param MobileOpportunity $opportunity
     */
    public function __construct(MobileOpportunity $opportunity)
    {
        $this->opportunity = $opportunity;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
