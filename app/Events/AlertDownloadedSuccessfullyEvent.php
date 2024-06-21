<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AlertDownloadedSuccessfullyEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $url;
    public $status;

    public function __construct($userId, $url, $status)
    {
        $this->userId = $userId;
        $this->url = $url;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            'AlertDownloadedSuccessfullyChannel',
        ];
    }

    public function broadcastAs()
    {
        return 'AlertDownloadedSuccessfullyEvent';
    }
}
