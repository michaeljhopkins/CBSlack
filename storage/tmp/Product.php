<?php namespace CS\Entities;

use Faker\Factory;

class Product extends BaseEntity
{
    public function __construct()
    {
        $f = Factory::create();
        parent::__construct('product');
    }
    public function find($uuid)
    {
        return $this->find($uuid);
    }

}