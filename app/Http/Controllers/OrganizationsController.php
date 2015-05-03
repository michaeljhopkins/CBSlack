<?php namespace CS\Http\Controllers;

use CS\Entities\Organization;
use Illuminate\Support\Collection;
use Input;
use Response;
use Slack;

class OrganizationsController extends BaseController {
    /**
     * @var Organization
     */
    private $organization;

    /**
     */
    public function __construct(){
        $this->organization =  new Organization();
    }

    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function findOrSearch()
    {
        $name = Input::get('name');
        $org = $this->organization->find($name);
        if($org->getStatusCode() === 404){
            $org2 = new Organization('organizations');
            $response = $org2->get();
            foreach($response as $r){
                Slack::to('#random')->send($r['name']);
                Slack::to('#random')->send('https://www.crunchbase.com/'.$r['path']);
            }
            return Response::json(['message' => 'success']);
        }
        else{
            $data = $org->getResponseBody()['data'];
            $properties = $data['properties'];
            $relationships = $data['relationships'];
            Slack::to('#random')->send('*'.$properties['name'].'* - '.$properties['short_description']);
            return Response::json(['message' => 'success']);
        }

    }

    public function show($uuid)
    {
        $reponse = $this->organization->find($uuid);
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
