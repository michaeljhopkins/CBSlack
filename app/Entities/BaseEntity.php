<?php namespace CS\Entities;

use Config;
use Drapor\Networking\Networking;
use Illuminate\Support\Collection;

class BaseEntity extends Networking{
    public $apiKey;

    public function __construct($baseUrl){
        /* relative path */
        $this->baseUrl          = $baseUrl;
        $this->options['query'] = true;
        $this->apiKey = config('CS.key');
    }

    public function get($endpoint,$page){

        $data = $this->send(['page' => $page,'user_key' => $this->apiKey], $endpoint, 'get')['body'];

        $collection = new Collection($data);

        return $collection;
    }
}