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

    /**
     * Overridden show method for ChatController to get people connected to chat object
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->getByIdWithPeopleObjects($id); // pull through people objects
        if ($data) {
            return $this->createSuccessResponse($data);
        }

        return $this->createErrorResponse($this->doesNotExist($id));
    }

    /**
     * Get chat by ID
     * @param $id
     *
     * @return mixed
     */
    protected function getByIdWithPeopleObjects($id)
    {
        $messages = call_user_func(array($this->model, 'find'), $id)->chatMessages()->with('person')->getResults();
        return $messages;
    }







}
