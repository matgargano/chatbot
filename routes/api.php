<?php

Route::resource('chats', 'ChatController', [
    'except' => ['destroy', 'update', 'edit', 'create']
]);

Route::resource('chatMessages', 'ChatMessageController', [
    'except' => ['destroy', 'update', 'edit', 'create']
]);

Route::resource('people', 'PersonController', [
    'except' => ['destroy', 'update', 'edit', 'create']
]);