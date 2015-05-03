<?php namespace Drapor\Networking\Traits;
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 1/14/15
 * Time: 10:39 PM
 */
trait TypeModifier{

    /**
     * @param $value
     * @return string
     */
    public function _toString($value)
    {
        $contents = $value;
        if($this->isJson($value)){
            $contents = \GuzzleHttp\json_decode($value, true);
            $string = $this->flatten($contents);
            return $string;
        }else{
         $contents =    $this->strip($contents);
        }

        return $contents;
    }

    private function strip($value){
        return e($value);
    }

    private function isJson($value){
       return is_string($value) && is_object(json_decode($value)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    /**
     * @param $contents
     * @return string
     */
    private function flatten($contents)
    {
        $string = '';
        foreach ($contents as $key => $val) {
            if (!is_array($val)) {
                $string = $this->format($key, $val, $string);
            }else{
                foreach($val as $k => $v){
                     $string = $this->format($key, $v, $string);
                }
            }
        }
        return $string;
    }

    /**
     * @param $key
     * @param $val
     * @param $string
     * @return array
     */
    private function format($key, $val, $string)
    {
        $key = $this->strip($key);
        $val = $this->strip($val);
        $output = ("{$key} : {$val}");
        $string .= "{$output}</br>";
        return  $string;
    }

}