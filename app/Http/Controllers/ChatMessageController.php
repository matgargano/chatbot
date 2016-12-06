<?php

namespace App\Http\Controllers;

use App\ChatMessage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class ChatMessageController extends BaseController
{

    protected $noun = 'chat message';

    public function __construct(ChatMessage $chatMessage)
    {
        $this->model = $chatMessage;
        //@todo middleware
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        try {
            $rules = [
                'chat_id'   => 'required|integer|exists:chats,id',
                'person_id' => 'required|integer|exists:people,id',
                'message'   => 'required'

            ];
            $this->validate($request, $rules);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            return $this->createErrorResponse($message, 500);
        }

        return parent::store($request);


    }

    /**
     * Display the specified resource.
     * @param Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {

        $data = call_user_func(array($this->model, 'find'), $id)->chat;
        if ($data) {
            return $this->createSuccessResponse($data);
        }

        return $this->createErrorResponse($this->doesNotExist($id));
    }


}
