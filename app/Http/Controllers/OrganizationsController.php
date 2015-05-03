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
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $name
     */
    public function findOrSearch()
    {
        $name = urlencode(Input::get('text'));
        $channel = '#'.Input::get('channel_name');
        $org = $this->organization->find($name);
        if($org->getStatusCode() === 404){
            $org2 = new Organization('organizations');
            try{
                $response = $org2->getOrgStuff();
            }
            catch(\Exception $e){
                Slack::to($channel)->send('Sorry. No Search Results');
                return Response::make(null,200);
            }
            foreach($response as $r){
                Slack::to($channel)->send($r['name']);
                Slack::to($channel)->send('https://www.crunchbase.com/'.$r['path']);
            }
            return Response::make(null,200);
        }
        else{
            $data = $org->getResponseBody()['data'];
            $properties = $data['properties'];
            $relationships = $data['relationships'];
            Slack::to($channel)->send('*'.$properties['name'].'* - '.$properties['short_description']);
            return Response::make(null,200);
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
