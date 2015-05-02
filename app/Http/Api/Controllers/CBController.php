<?php namespace CS\Http\Api\Controllers;

use CS\Entities\Organization;

class CBController extends BaseController {

	public function index()
	{
		//
	}
	public function show($id)
	{
		$reponse = Organization::find($id);
        return $reponse;
	}

}
