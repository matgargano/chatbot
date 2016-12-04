<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;

class ChatController extends BaseController
{


    protected $noun = 'chat';

    public function __construct(Chat $chat)
    {
        $this->model = $chat;
        //@todo middleware
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $object = call_user_func(array($this->model, 'create'));
        return $this->createSuccessResponse( $object, 201 );
    }







}
