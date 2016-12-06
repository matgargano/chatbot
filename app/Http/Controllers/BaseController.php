<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $noun = 'thing';
    protected $model;

    public function createSuccessResponse($data, $code = 200)
    {
        return response()->json(['data' => $data, 'code' => $code], $code);
    }

    public function alreadyExists($id, $noun = null)
    {
        $noun = $noun ?: $this->noun;

        return sprintf('A very similar %s already exists at id %d', $noun, $id);
    }


    public function createErrorResponse($message, $code = 404, $id = null)
    {
        $array_response = ['message' => $message, 'code' => $code];
        if ($id) {
            $array_response = array_merge($array_response, array('id' => $id));
        }

        return response()->json($array_response, $code);
    }

    public function created($id, $noun = null)
    {
        return $this->createResponseText($id, $this->getShortName(__METHOD__), $noun);
    }

    private function getShortName($longName = null)
    {

        $longNameExploded = explode('::', $longName);


        return array_pop($longNameExploded);
    }

    private function createResponseText($id, $verb, $noun = null)
    {
        $noun = $noun ?: $this->noun;

        return sprintf('The %s with the id of %d has been %s', $noun, $id, $verb);

    }

    public function doesNotExist($id, $noun = null)
    {
        $noun = $noun ?: $this->noun;

        return sprintf('No %s exists at id %d', $noun, $id);
    }


    /**
     * Get chat by ID
     * @param $id
     *
     * @return mixed
     */
    protected function getById($id)
    {
        return call_user_func(array($this->model, 'find'), $id);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $chats = call_user_func(array($this->model, 'all'));

        return $this->createSuccessResponse($chats);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->getById($id);
        if ($data) {
            return $this->createSuccessResponse($data);
        }

        return $this->createErrorResponse($this->doesNotExist($id));
    }

    public function store(Request $request){
        $object = call_user_func( array(
            $this->model,
            'create'
        ), $request->all() );

        return $this->createSuccessResponse( $this->created( $object->id ), 201 );
    }


}
