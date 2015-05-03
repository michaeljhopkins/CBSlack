<?php namespace CS\Entities;


use Config;
use Exception;
use Illuminate\Support\Collection;

class Organization extends BaseEntity
{
    public function __construct($endpoint = null)
    {
        if($endpoint){
            parent::__construct($endpoint);
        }
        else{
            parent::__construct('organization');
        }

    }
    public function find($name)
    {
        return parent::find($name);
    }

    public function getOrgStuff()
    {
        $data = $this->send(['page' => 1,'user_key' => Config::get('cb.key'),'query' => \Input::get('text')], $this->endpoint, 'get')['body'];
        if(array_key_exists('message',$data) && $data['message'] == 'No Response Received.'){
            throw new Exception('No Search Results');
        }
        else{
            $arrays = array_slice($data['data']['items'],0,5);
            $col = new Collection();
            foreach($arrays as $array)
            {
                $col->push($array);
            }
            $this->collection = $col->toArray();
        }
        return $this->collection;
    }

}