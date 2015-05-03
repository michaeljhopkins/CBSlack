<?php namespace CS\Entities;

use Faker\Factory;

class Person extends BaseEntity
{
    public function __construct()
    {
        $f = Factory::create();
        parent::__construct('person');
    }
    public function find($uuid)
    {
        return $this->find($uuid);
    }

}