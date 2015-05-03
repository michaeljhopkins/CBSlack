<?php namespace CS\Http\Controllers;

use CS\Entities\Organization;

class OrganizationsController extends BaseController {
    /**
     * @var Organization
     */
    private $organization;

    /**
     * @param Organization $organization
     */
    public function __construct(Organization $organization){
        $this->organization = $organization;
    }

    public function findOrSearch($name)
    {
        $response = $this->organization->find($name);
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
