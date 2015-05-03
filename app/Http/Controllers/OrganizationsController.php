<?php namespace CS\Http\Controllers;

use CS\Entities\Organization;

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

    public function findOrSearch($name)
    {
        $org = $this->organization->find($name);
        if($org->getStatusCode() === 404){
            $org2 = new Organization();
            $org2->setEndpoint('organizations');
            $response = $org2->get(1);
        }
        else{
            $response = $org;
        }
        return \Response::json($response);

    }

    public function show($uuid)
    {
        $reponse = $this->organization->find($uuid);
        return $reponse;
    }

    public function search()
    {

    }
}
