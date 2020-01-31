<?php

namespace App\Observers;

use App\ChatMessage;
use App\Events\ChatMessageEvent;
use Carbon\Carbon;

class ChatMessageObserver
{
    /**
     * Handle the chat message "created" event.
     *
     * @param  \App\ChatMessage  $chatMessage
     * @return void
     */
    public function created(ChatMessage $chatMessage)
    {
        $tmp = $chatMessage;
        $user = $tmp->chat->website->user_id;
        $chatMessage->chat->update([
            'last_message' => Carbon::now()
        ]);
        event(new ChatMessageEvent($chatMessage, $user));
    }

    /**
     * Handle the chat message "updated" event.
     *
     * @param  \App\ChatMessage  $chatMessage
     * @return void
     */
    public function updated(ChatMessage $chatMessage)
    {
        //
    }

    /**
     * Handle the chat message "deleted" event.
     *
     * @param  \App\ChatMessage  $chatMessage
     * @return void
     */
    public function deleted(ChatMessage $chatMessage)
    {
        //
    }

    /**
     * Handle the chat message "restored" event.
     *
     * @param  \App\ChatMessage  $chatMessage
     * @return void
     */
    public function restored(ChatMessage $chatMessage)
    {
        //
    }

    /**
     * Handle the chat message "force deleted" event.
     *
     * @param  \App\ChatMessage  $chatMessage
     * @return void
     */
    public function forceDeleted(ChatMessage $chatMessage)
    {
        //
    }
}
