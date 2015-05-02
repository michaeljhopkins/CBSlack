<?php namespace CS\Entities;

use Config;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseEntity extends Model{
    public static function find($uuid)
    {
        $org = new Organization();
        $url = 'http://api.crunchbase.com/v/2/';
        $response = $org->curl_execute($url.'organization/'.$uuid);
        return $response;
    }
    public function curl_execute($url)
    {
        $fullUrl = $url.'&user_key='.Config::get('CS.key');
        $ch = curl_init($fullUrl);
        curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER	=> TRUE, CURLOPT_TIMEOUT => 5]);

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status !== 200) {
            $return = "HTTP call failed with error {$http_status}.";
        }
        elseif ($response === FALSE){
            $return = 'HTTP call failed empty response.';
        }
        else{
            /** @var \Illuminate\Support\Collection $collection */
            $collection = new Collection($response);
            $return = $collection->first();
        }
        return $return;
    }
}