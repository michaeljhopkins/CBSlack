<?php namespace CS\Entities;

class Organization extends BaseEntity
{
    public function __construct()
    {
        parent::__construct('organization');
    }
    public function find($uuid)
    {
        return $this->find($uuid);
    }

}