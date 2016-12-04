<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_id', 'id');
    }

}
