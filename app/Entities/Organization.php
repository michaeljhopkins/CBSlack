<?php namespace CS\Entities;

use Faker\Factory;

class Organization extends BaseEntity
{
    public function __construct()
    {
        parent::__construct('organization');
    }
    public function find($uuid)
    {
        return parent::find($uuid);
    }

}