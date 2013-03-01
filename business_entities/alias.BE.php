<?php

require_once __DIR__ . "/base.BE.php";

class alias__BE extends base__BE {


	protected function __construct($a_fields_array) {
		parent::__construct($a_fields_array);
	}

	public static function create_from_record($a_business_entity_record) {
		$ret_val = null;

		$instance = new alias__BE($a_business_entity_record);
		//$instance = parent::create_from_record($a_business_entity_record);

		foreach ($a_business_entity_record as $field_name => $field_value) {
			$instance->$field_name = $field_value;
		}

		//$instance->fields = $a_business_entity_record;

		$ret_val = $instance;

		return $ret_val;
	}

	public static function create_from_POST_array($a_post_array){
		
		$data = parent::POST_array__prepare($a_post_array);
		
		$instance = new alias__BE($data);

		foreach($data as $field_name=>$field_value){
			//$instance->$field_name = $field_value;
			$instance->_set($field_name, $field_value);
		}
		
		//$instance->fields = $a_business_entity_record;
		
		$ret_val = $instance;
		
		return $ret_val;
	}
	
	/*
	  protected function name__get(){
	  return  "name=" .$this->name;
	  }
	 */

	/*
	  protected function name__set($a_value){
	  $this->name = $a_value;
	  }
	 */
}
