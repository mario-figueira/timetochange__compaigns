<?php

require_once REALPATH .'util/DBCHelper.php';

class base__BE {	
	
	protected $_base_fields = array();
	protected $_validations = array();
	
	protected function __construct($a_fields_array){
		DBCHelper2::require_that()->the_param($a_fields_array)->is_an_array_with_at_least_one_element();
		$this->_base_fields = $a_fields_array;		
	}
	
	public static function create_from_record($a_business_entity_record){
		DBCHelper2::require_that()->the_param($a_business_entity_record)->is_an_array_with_at_least_one_element();
		
		$ret_val = null;
		
		$instance = new base__BE($a_business_entity_record);

		foreach($a_business_entity_record as $field_name=>$field_value){
			$instance->$field_name = $field_value;
		}
		
		
		//$instance->fields = $a_business_entity_record;
		
		$ret_val = $instance;
		
		return $ret_val;
	}
	
	public static function create_from_POST_array($a_POST_array){
		DBCHelper2::require_that()->the_param($a_POST_array)->is_an_array_with_at_least_one_element();
		
		$ret_val = null;
		
		
		$keys_to_extract = array_filter(
			array_keys($a_POST_array)
			, function($a_element){
				$prefix_found = strpos($a_element, "field__")!==false;
				return $prefix_found;			
			}
		);
		
		$keys_to_extract = array_flip($keys_to_extract);
		
		$raw_data = array_intersect_key($a_POST_array, $keys_to_extract);
		
		$data = array();
		foreach($raw_data as $key=>$value){
			$new_key = substr($key, strlen("field__")); 
			$data[$new_key] = $raw_data[$key];
		}
		
		
		$instance = new base__BE($data);

		foreach($a_business_entity_record as $field_name=>$field_value){
			$instance->$field_name = $field_value;
		}
		
		
		//$instance->fields = $a_business_entity_record;
		
		$ret_val = $instance;
		
		return $ret_val;
	}
		
	public function update_field_matches_from_array($a_array_of_values){
		DBCHelper2::require_that()->the_param($a_array_of_values)->is_an_array_with_at_least_one_element();

		$this_class = get_class($this);
		$class_declared_fields = get_class_vars($this_class);
		foreach($a_array_of_values as $field_name=>$field_value){
			$class_field_exists = key_exists($field_name, $class_declared_fields);
			if($class_field_exists){
				$this->$field_name = $field_value;
			}else{
				$field_exists = key_exists($field_name, $this->_base_fields);
				if($field_exists){
					$this->_base_fields[$field_name] = $field_value;
				}
			}
		}
	}
	
	//magic methods for get/set interception
	public function __get($a_field_name) {
		DBCHelper2::require_that()->the_param($a_field_name)->is_a_string();

		$ret_val = null;
		
		$field_value = null;
		
		$this_class = get_class($this);
		$class_declared_fields = get_class_vars($this_class);
		$class_field_exists = key_exists($a_field_name, $class_declared_fields);

		$get_method = $a_field_name ."__get";
		$has_get_method = is_callable(array($this_class, $get_method));

		if($has_get_method){
			$field_value = $this->$get_method();
		}else if($class_field_exists){
			$field_value = $this->$a_field_name;			
		}else{
			$field_value = $this->_get_field_value($a_field_name);
		}
		
		$ret_val = $field_value;
		
		return $ret_val;		
	}
	
	public function __set($a_field_name, $a_field_value) {
		DBCHelper2::require_that()->the_param($a_field_name)->is_a_string();
		
		$this_class = get_class($this);
		$class_declared_fields = get_class_vars($this_class);
		$class_field_exists = key_exists($a_field_name, $class_declared_fields);

		$set_method = $a_field_name ."__set";
		$has_set_method = is_callable(array($this_class, $set_method));
		
		if($has_set_method){
			$this->$set_method($a_field_value);/*TODO rever método não existe*/
		}else if($class_field_exists){
			$this->$field_name = $a_field_value;
		}else{
			$this->_set_field_with_value($a_field_name, $a_field_value);
		}
		
	}
	
	
	protected function _get_field_value($a_field_name){
		DBCHelper2::require_that()->the_param($a_field_name)->is_a_string();

		$ret_val = null;
		
		$field_value = null; 
		
		if(key_exists($a_field_name, $this->_base_fields)){
			$field_value = $this->_base_fields[$a_field_name];
		}else{
			throw new field_doesnt_exists($a_field_name);
		}		
		
		$ret_val = $field_value;
		
		return $ret_val;
	}
	
	protected function _set_field_with_value($a_field_name, $a_value){
		DBCHelper2::require_that()->the_param($a_field_name)->is_a_string();

		//$ret_val = null;
		
		if(key_exists($a_field_name, $this->_base_fields)){
			$this->_base_fields[$a_field_name] = $a_value;
		}
		else{
			throw new field_doesnt_exists($a_field_name);
		}
		
		//$ret_val = $field_value;
		
		//return $ret_val;
	}
	
	public function _get_fields_array(){
		$ret_val = null;
		
		$ret_val = $this->_base_fields;
		
		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_an_array_with_at_least_one_element();
		return $ret_val;
	}
	
	protected function register_validation($a_field_name, $a_validation_callback, $a_is_invalid_message){
		$this->_validations[$a_field_name][] = array("callback"=>$a_validation_callback, "is_invalid_message"=>$a_is_invalid_message);		
	}
	
	public function is_valid(){
		$ret_val = array();
		foreach ($this->_validations as $field_name=>$field_validations){
			
			$field_value = $this->$field_name;
			$evaluation_result = $this->value_is_valid_for_field($field_value, $field_name);			
			
			$ret_val[$field_name] = $evaluation_result;			
			
		}		
	}
	
	protected function value_is_valid_for_field($a_value, $a_field_name){
		$ret_val = null;
		
		$field_validations = $this->_validations[$a_field_name];
		
		$field_is_valid = true;
		$invalid_messages = array();
		foreach($field_validations as $validation_descriptor){
			//$field_name = $field_validations[0];
			$callback = $validation_descriptor['callback'];
			$is_invalid_message = $validation_descriptor['is_invalid_message'];
			$field_value = $a_value; 
			$is_valid = call_user_func($callback, $field_value);
			$field_is_valid &= $is_valid;
			$invalid_messages[] = $is_invalid_message;				
		}
		$field_result = array("is_valid"=>$field_is_valid, "invalid_messages"=>$invalid_messages);
		
		$ret_val = $field_result;
		
		return $ret_val;		
	}
	
}

class field_doesnt_exists extends Exception{
	public $field_name;
	
	public function __construct($a_field_name){
		$this->field_name = $a_field_name;
	}
}