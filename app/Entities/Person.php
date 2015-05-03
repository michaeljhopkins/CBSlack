<?php namespace CS\Entities;


class Person extends BaseEntity
{
    public function __construct($endpoint = null)
    {
        if($endpoint){
            parent::__construct($endpoint);
        }
        else{
            parent::__construct('person');
        }

    }
    public function find($name)
    {
        $response = parent::find($name);
        if($response->getStatusCode() != 404)
        {
            return $response->getResponseBody()['data'];
        }
        else{
            $org2 = new Person('persons');
            try{
                $response = $org2->get();
            }
            catch(\Exception $e){
                return null;
            }
            return $response;
        }
    }

}