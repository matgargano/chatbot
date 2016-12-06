<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Person;
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

        return $this->createSuccessResponse($object, 201);
    }

    /**
     * Overridden show method for ChatController to get people connected to chat object
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data = $this->getByIdWithPeopleObjects($id); // pull through people objects
        if ($data) {
            return $this->createSuccessResponse($data);
        }

        return $this->createErrorResponse($this->doesNotExist($id));
    }

    /**
     * Get chats
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function index(Request $request)

    {

        if ($request->input('userId')) {

            $chats = call_user_func(array($this->model, 'distinct'))->select('chats.*')->leftJoin('chat_messages',
                function ($join) {
                    $join->on('chats.id', '=', 'chat_messages.chat_id');
                })->where('chat_messages.person_id', (int)$request->input('userId'))->get();


        } else {

            $chats = call_user_func(array($this->model, 'all'));
        }

        return $this->createSuccessResponse($chats);

    }

    public function destroy($id)
    {

        $data = $this->getById( $id );

        if ( $data ) {

            $data->delete();

            return $this->createSuccessResponse( $data );
        }

        return $this->createErrorResponse( $this->doesNotExist( $id ), 404 );

    }

    /**
     * Get chat by ID and bring along people objects
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
