<?php namespace CS\Entities;

class Organization extends BaseEntity
{
    public function show($uuid)
    {
        $base_url = 'http://api.crunchbase.com/v/2/';
        $uri = 'organization/'.$uuid;
        $this->curl_execute($base_url.$uri);
    }
}