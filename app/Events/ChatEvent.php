<?php

namespace App\Events;

use App\Models\User;
use App\Models\Room;
use App\Models\Message;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $room;
    public $message;

    public function __construct(User $user, Room $room, Message $message)
    {
        $this->user = $user;
        $this->room = $room;
        $this->message = $message;
    }

    public function broadcastWith()
    {
        // This must always be an array. Since it will be parsed with json_encode()
        // return [
        //     'chat' => $this->chat,
        // ];

        return array_merge($this->message->toArray(), ['user' => $this->user->only('id', 'name')]);
    }

    public function broadcastAs()
    {
        return 'chat-user';
    }

    public function broadcastOn()
    {
        return new PresenceChannel('chat.room.' . $this->room->id);
    }
}
