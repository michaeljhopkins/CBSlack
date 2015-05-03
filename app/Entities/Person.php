<?php namespace CS\Entities;


class Person extends BaseEntity
{
    public function __construct($endpoint = null)
    {
        if($endpoint){
            $this->setEndpoint($endpoint);
        }
        parent::__construct('person');
    }
    public function find($name)
    {
        return parent::find($name);
    }

}