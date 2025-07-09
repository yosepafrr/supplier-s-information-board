<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PanggilAntrianEvent implements ShouldBroadcast
{
    use SerializesModels;

    public $panggilan;

    public function __construct($panggilan)
    {
        $this->panggilan = $panggilan;
    }

    public function broadcastOn()
    {
        return new Channel('monitor-channel');
    }
}