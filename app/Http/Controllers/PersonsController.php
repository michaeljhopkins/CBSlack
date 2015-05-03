<?php namespace CS\Http\Controllers;

use CS\Entities\Person;

class PersonsController extends BaseController {
    /**
     * @var Person
     */
    private $person;

    /**
     * @param Person $person
     */
    public function __construct(Person $person){
        $this->person = $person;
    }

    public function index()
    {
        //
    }
    public function show($uuid)
    {
        $reponse = $this->person->show($uuid);
        return $reponse;
    }

}
