<?php

require_once __DIR__ . "/base.BE.php";

class account__BE extends base__BE {

	protected $idAccount;
	protected $name;
	protected $email;
	protected $zip1;
	protected $zip2;

	protected function __construct($a_fields_array) {
		parent::__construct($a_fields_array);
		
		//parent::register_validation("email", array($this, 'string__is_valid_email'), "email is inválid");
		//parent::register_validation("email", array($this, 'string__is_valid_email'), "email is not valid");
		//parent::register_validation("name", array($this, 'name_is_valid'), "name is not valid");
	}

	public static function create_from_record($a_business_entity_record) {
		$ret_val = null;

		$instance = new account__BE($a_business_entity_record);
		//$instance = parent::create_from_record($a_business_entity_record);

		foreach ($a_business_entity_record as $field_name => $field_value) {
			$instance->$field_name = $field_value;
		}

		//$instance->fields = $a_business_entity_record;

		$ret_val = $instance;

		return $ret_val;
	}


	protected function email__set($a_value) {
		
		$value_is_set = isset($a_value);
		
		if($value_is_set){
			$evaluation_result = $this->value_is_valid_for_field($a_value, "email");
			$value_is_valid = $evaluation_result['is_valid'];
			if (!$value_is_valid) {
				$is_invalid_message = $evaluation_result['invalid_messages'];
				throw new Exception("Parameter a_value=[{$a_value}] is not a valid email.");
			}
		}
		$this->email = $a_value;
	}

	protected function string__is_valid_email($a_email_address_str) {
		$ret_val = false;

		$ret_val = (filter_var($a_email_address_str, FILTER_VALIDATE_EMAIL) != false);

		return $ret_val;
	}

	protected function name_is_valid($a_name) {
		$ret_val = false;

		$ret_val = strlen($a_name)>100;

		return $ret_val;
	}


}
