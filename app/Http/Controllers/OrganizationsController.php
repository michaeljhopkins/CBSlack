<?php namespace CS\Http\Controllers;

use CS\Entities\Organization;
use Illuminate\Support\Collection;
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
    public function findOrSearch($name)
    {
        $org = $this->organization->find($name);
        if($org->getStatusCode() === 404){
            $org2 = new Organization();
            $org2->setEndpoint('organizations');
            $response = array_slice($org2->get(1)->collection['data']['items'], 0, 5);
            foreach($response as $r){
                Slack::to('#random')->send($r['name']);
                Slack::to('#random')->send('https://www.crunchbase.com/'.$r['path']);
            }
        }
        else{
            return Response::json($org);
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
