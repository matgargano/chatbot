<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{

    protected $fillable = [ 'person_id', 'chat_id', 'message' ];

    public function chat(){
        return $this->belongsTo(Chat::class, 'chat_id', 'id');
    }

    public function person(){
        return $this->hasOne(Person::class, 'person_id', 'id');
    }
}
