<?php namespace CS\Entities;

use Config;
use Drapor\Networking\Networking;
use Illuminate\Support\Collection;

class BaseEntity extends Networking {
    public $endpoint;
    public $entity;
    /* @var $collection Collection  */
    public $collection;

    public function __construct($endpoint){
        /* relative path */
        $this->baseUrl = 'http://api.crunchbase.com/v/2';
        $this->endpoint = $endpoint;
        $this->options['query'] = true;
        parent::__construct();
    }

    public function get($page){
        $data = $this->send(['page' => $page,'user_key' => Config::get('cb.key')], $this->endpoint, 'get')['body'];
        $this->collection = new Collection($data);
        return $this;
    }

    public function find($id){
        return $this->send(['user_key' => Config::get('cb.key')], $this->endpoint . '/' . $id ,'get')['body'];
    }

    public function first(){
        return $this->collection->first();
    }

    public function where($key,$value){
        return $this->collection->where($key,$value);
    }
    
     public function __call($key,$args){
        return $this->collection->where($key,$args[0]);
    }

    public function __get($property){
        if(property_exists($this,$property)){
            return $this->$property;
        }else{
            return null;
        }
    }
    public function __set($property,$value){
        $this->$property = $value;
    }
    
}
