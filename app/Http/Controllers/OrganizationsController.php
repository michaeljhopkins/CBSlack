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
        dd($this->organization->find($name));
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
