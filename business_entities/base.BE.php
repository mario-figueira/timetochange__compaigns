<?php

require_once REALPATH .'util/DBCHelper.php';

class base__BE {	
	
	protected $_base_fields = array();
	
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
	
}

class field_doesnt_exists extends Exception{
	public $field_name;
	
	public function __construct($a_field_name){
		$this->field_name = $a_field_name;
	}
}