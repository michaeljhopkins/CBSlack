<?php namespace CS\Http\Controllers;

use CS\Entities\Person;
use Illuminate\Support\Collection;
use Input;
use Response;
use Slack;

class PersonsController extends BaseController {
    /**
     * @var Person
     */
    private $person;

    /**
     */
    public function __construct(){
        $this->person =  new Person();
    }

    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function findOrSearch()
    {
        $textInput = Input::get('text');
        $name = str_replace(' ','-',trim($textInput));
        $channel = '#'.Input::get('channel_name');
        $org = $this->person->find($name);
        if($org) {
            $properties = $org['properties'];
            $relationships = $org['relationships'];
            Slack::to($channel)->send('*' . $properties['last_name'] . ', ' . $properties['first_name'] . '* - ' . $properties['bio']);
            return Response::make(null, 200);
        }
        else{
            Slack::to($channel)->send('No Search Results');
        }

    }

    public function show($uuid)
    {
        $reponse = $this->person->find($uuid);
        return $reponse;
    }

    public function search()
    {

    }

    private function respondSearch($response)
    {
        return Response::json($response);
    }

    private function respondSingle($org)
    {
        return Response::json($org);
    }
}
