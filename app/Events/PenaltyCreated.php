<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PenaltyCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $penalty;

    public function __construct($penalty)
    {
        $this->penalty = $penalty;
    }

    public function broadcastOn()
    {
        return new Channel('penalties');
    }
}