<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [ 'name', 'email' ];

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_id', 'id');
    }

}
