<?php namespace CS\Entities;

class Organization extends BaseEntity
{
    public static function find($uuid)
    {
        return $this->get('organization'.$uuid)->first();
    }

}