<?php

namespace App\Events;

use App\Models\User;
use http\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $receiver;
    public string $message;


    public function __construct(User $receiver, $message)
    {
        $this->receiver = $receiver;
        $this->message = $message;
    }

    public function BroadcastOn()
    {
        return [
            new Channel('chat' . $this->receiver->id),
        ];
    }

    public function BroadcastAs()
    {
        return "chatMessage";
    }
}
