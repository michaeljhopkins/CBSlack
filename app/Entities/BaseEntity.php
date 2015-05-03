<?php namespace CS\Entities;

use Config;
use Drapor\Networking\Networking;
use Illuminate\Support\Collection;

class BaseEntity extends Networking {
    public $endpoint;
    public $entity;
    /* @var $collection Collection  */
    public $collection;
    public $attributes;

    public function __construct($endpoint, $attributes = []){
        /* relative path */
        $this->attributes = [];
        $this->baseUrl    = 'http://api.crunchbase.com/v/2';
        $this->endpoint   = $endpoint;
        $this->options['query'] = true;
        parent::__construct();
        
        if(count($attributes) > 0){
            $this->setAttributes($attributes);
        }
    }

    public function get($page){
        $data = $this->send(['page' => $page,'user_key' => Config::get('cb.key')], $this->endpoint, 'get')['body'];
        $this->collection = new Collection($data);
        return $this;
    }

    public function find($id){
        $object =  $this->send(['user_key' => Config::get('cb.key')], $this->endpoint . '/' . $id ,'get')['body'];
        $this->setAttributes($object);
        
        return $this;
    }

    public function first(){
        $object =  $this->collection->first();
        
        $this->setAttributes($object);
        
        return $this;
    }

    public function where($key,$value){
        $this->collection =  $this->collection->where($key,$value);
        
        return $this;
    }
    
     public function __call($key,$args){
        $this->collection =  $this->collection->where($key,$args[0]);
        
        return $this;
    }

    public function __get($property){
        if(array_key_exists($this->attributes,$property)){
            return $this->attributes[$property];
        }else{
            return null;
        }
    }
    public function __set($property,$value){
        $this->attributes[$property] = $value;
    }
    
    private function setAttributes($attributes){
          foreach($attributes as $key => $value){
            $this->attributes[$key] = $value;
        }
    }
    
}
