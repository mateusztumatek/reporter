<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['chat_id', 'type', 'message', 'attachments', 'seen'];
    protected $appends = ['created_diff'];
    public function getCreatedDiffAttribute(){
        return $this->created_at->diffForHumans();
    }
    public function chat(){
        return $this->belongsTo('App\Chat');
    }
}
