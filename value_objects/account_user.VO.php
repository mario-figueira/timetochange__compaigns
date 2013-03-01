<?php

require_once REALPATH . "/business_entities/base.BE.php";

class account_user__VO extends base__BE {

	protected $account;
	protected $user;
	protected $role;

	protected function __construct($a_fields_array) {
		parent::__construct($a_fields_array);
		
		parent::register_validation("email", array($this, 'string__is_valid_email'), "email is inválid");
		//parent::register_validation("email", array($this, 'string__is_valid_email'), "email is not valid");
		parent::register_validation("name", array($this, 'name_is_valid'), "name is not valid");
	}

	public static function create_from_record($a_business_entity_record) {
		$ret_val = null;

		$instance = new account_user__VO($a_business_entity_record);
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
		
		$instance = new account_user__VO($data);

		foreach($data as $field_name=>$field_value){
			//$instance->$field_name = $field_value;
			$instance->_set($field_name, $field_value);
		}
		
		//$instance->fields = $a_business_entity_record;
		
		$ret_val = $instance;
		
		return $ret_val;
	}
	
	public static function create($a_account_user_record, $a_account, $a_user, $a_role){
		$instance = account_user__VO::create_from_record($a_account_user_record);
		
		$instance->user = $a_user;
		$instance->account = $a_account;
		$instance->role = $a_role;
		
		$ret_val = $instance;
		
		return $ret_val;
	}


}
