<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = ['name', 'email'];

    protected $guarded = ['admin'];

    protected $casts = [
        'admin' => 'boolean',
    ];

    public function chatMessages()
    {
        return $this->belongsToMany(ChatMessage::class, 'chats', 'id', 'id');
    }

    public function chat(){

        return $this->belongsToMany(\App\Chat::class);

    }

}
