<?php

namespace App\Events;

use App\ChatMessage;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $chat_message;
    private $user_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ChatMessage $chat_message, $user_id)
    {
        $this->chat_message = $chat_message;
        $this->chat_message->chat->load('websiteUser');
        $this->user_id = $user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('UserEvents.'.$this->user_id),
            new Channel('ChatChannel.'.$this->chat_message->chat->hash)
        ];
    }
    public function broadcastAs(){
        return 'message';
    }
}
