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
        return $this->createSuccessResponse( $object, 201 );
    }
}
