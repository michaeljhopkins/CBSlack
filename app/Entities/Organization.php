<?php namespace CS\Entities;


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

}