<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewsSearched
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $news;

    public function __construct($news)
    {
        $this->news = $news;
    }

    public function broadcastOn()
    {
        return new Channel('search-news');
    }
}
