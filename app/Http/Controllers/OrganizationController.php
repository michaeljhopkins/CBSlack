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

    public function index()
    {
        //
    }
    public function show($uuid)
    {
        $reponse = $this->organization->find($uuid);
        return $reponse;
    }
}
