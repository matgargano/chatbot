<?php

Route::resource('chat', 'ChatController', [
    'except' => ['destroy', 'update', 'edit', 'create']
]);

Route::resource('chatMessage', 'ChatMessageController', [
    'except' => ['destroy', 'update', 'edit', 'create']
]);

Route::resource('person', 'PersonController', [
    'except' => ['destroy', 'update', 'edit', 'create']
]);