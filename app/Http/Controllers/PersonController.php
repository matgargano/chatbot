<?php

namespace App\Http\Controllers;

use App\Person;
use Illuminate\Http\Request;

class PersonController extends BaseController
{

    protected $noun = 'person';


    public function __construct(Person $person)
    {
        $this->model = $person;
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

        $rules = [
            'name'  => 'required',
            'email' => 'required|email'

        ];
        try {
            $this->validate($request, $rules);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();

            return $this->createErrorResponse($message, 422);
        }

        $object = call_user_func(array($this->model, 'create'), $request->toArray());

        return $this->createSuccessResponse($object, 201);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->input('admin')) {
            $objects = call_user_func(array($this->model, 'where'), 'admin', 1)->get();
        } else {

            $objects = call_user_func(array($this->model, 'all'));

        }

        return $this->createSuccessResponse($objects);

    }

    public function update(Request $request, $id)
    {

        $object = $this->getById($id);
        $rules  = [
            'name' => 'required',

        ];
        try {
            $this->validate($request, $rules);
        } catch (\Exception $ex) {
            $message = $ex->getMessage();

            return $this->createErrorResponse($message, 500);
        }

        if ($object) {
            $object->name = $request->name;
            $object->save();
            return $this->createSuccessResponse( $object );


        }

        return $this->createErrorResponse($this->doesNotExist($id), 404);

    }
}
