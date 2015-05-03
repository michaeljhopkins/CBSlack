<?php namespace Drapor\Networking\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Drapor\Networking\Traits\TypeModifier;
	/**
	 * Created by PhpStorm.
	 * User: michaelkantor
	 * Date: 1/9/15
	 * Time: 9:12 PM
	 */
	class Request extends Eloquent {

        use TypeModifier;

		protected $table ='service_requests';

		protected $guarded = [];
        protected $hidden  = [];
		public $timestamps = true;



        public function getRequestBodyAttribute( $value)
        {
            return $this->_toString($value);
        }

        public function getResponseBodyAttribute( $value)
        {
            return $this->_toString($value);
        }

        public function getRequestHeadersAttribute($value){
            return $this->_toString($value);
        }

        public function getResponseHeadersAttribute($value){
            return $this->_toString($value);
        }

        public function getTimeElapsedAttribute($value){
            $value = round($value,4);
            return "{$value} seconds elapsed.";
        }

        public function getCookiesAttribute($value){
            if(!(count($value) > 1)){
                return "No Cookies In Response";
            }else{
                return $this->_toString($value);
            }
        }

        public function getStatusCodeAttribute($value){
            if($value >= 200 && $value <= 300){
                return "<span class='label label-success'>{$value}</span>";
            }elseif($value >= 300 && $value <= 500){
                return "<span class='label label-warning'>{$value}</span>";
            }elseif($value <= 500){
                return "<span class='label label-warning'>{$value}</span>";
            }else{
                return "<span class='label label-default'>{$value}</span>";
            }
        }


    }