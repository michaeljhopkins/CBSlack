<?php namespace CS\Entities;

use Faker\Factory;

class Organization extends BaseEntity
{
    public function __construct()
    {
        $f = Factory::create();
        $attr = [
            'permalink' => $f->text(30),
            'api_path' => $f->url,
            'web_path' => $f->url,
            'name' => $f->company,
            'also_known_as' => [$f->company,$f->company]
        ];
        parent::__construct('organization',$attr);
    }
    public function find($uuid)
    {
        return $this->find($uuid);
    }

}