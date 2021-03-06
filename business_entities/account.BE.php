<?php

require_once __DIR__ . "/base.BE.php";

class account__BE extends base__BE {

	protected $name;
	protected $email;
	protected $zip1;
	protected $zip2;
	protected $zip;
	
	private $users;
	

	protected function __construct($a_fields_array) {
		parent::__construct($a_fields_array);
		
		parent::register_validation("email", array($this, 'string__is_valid_email'), "email is inválid");
		//parent::register_validation("email", array($this, 'string__is_valid_email'), "email is not valid");
		parent::register_validation("name", array($this, 'name_is_valid'), "name is not valid");
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
	
	public static function create_from_POST_array($a_post_array){
		
		$data = parent::POST_array__prepare($a_post_array);
		
		$instance = new account__BE($data);

		foreach($data as $field_name=>$field_value){
			//$instance->$field_name = $field_value;
			$instance->_set($field_name, $field_value);
		}
		
		//$instance->fields = $a_business_entity_record;
		
		$ret_val = $instance;
		
		return $ret_val;
	}

	
	private function zip_compute_and_set(){
		$zip_value = $this->zip1 ."-" . $this->zip2;		
		$this->_set('zip', $zip_value);
	}
	
	protected function zip1__set($a_value) {
		$this->zip1 = $a_value;
		$this->zip_compute_and_set();
	}

	protected function zip2__set($a_value) {
		$this->zip2 = $a_value;
		$this->zip_compute_and_set();
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

		$ret_val = strlen($a_name)>1;

		return $ret_val;
	}

	
	public function users__add_user($a_user){
		$users[] = $a_user;
	}

	public function users__get($a_user){
		return $users;
	}

}
