<?php

require_once REALPATH . "/business_entities/base.BE.php";

class account_alias__VO extends base__BE {

	protected $account;
	protected $alias;

	protected function __construct($a_fields_array) {
		parent::__construct($a_fields_array);		
	}

	public static function create_from_record($a_business_entity_record) {
		$ret_val = null;

		$instance = new account_alias__VO($a_business_entity_record);
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
		
		$instance = new account_alias__VO($data);

		foreach($data as $field_name=>$field_value){
			//$instance->$field_name = $field_value;
			$instance->_set($field_name, $field_value);
		}
		
		//$instance->fields = $a_business_entity_record;
		
		$ret_val = $instance;
		
		return $ret_val;
	}
	
	public static function create($a_account_alias_record, $a_account, $a_alias){
		$instance = account_alias__VO::create_from_record($a_account_alias_record);
		
		$instance->alias = $a_alias;
		$instance->account = $a_account;
		
		$ret_val = $instance;
		
		return $ret_val;
	}


}
