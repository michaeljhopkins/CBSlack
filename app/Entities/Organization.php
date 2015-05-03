<?php namespace CS\Entities;

class Organization extends BaseEntity
{
    public function show($uuid)
    {
        return $this->find('organization',$uuid);
    }
}