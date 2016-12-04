<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'id', 'chat_message_id');
    }

}
