<?php

require_once __DIR__ . "/base.DTO.php";

class prompt_to_accounts__VTO extends base__DTO{

	protected $available_accounts;
	protected $field__name;
	protected $field__idAccounts;
	protected $field__idPrompt;
	protected $field__prompt_file_name;
	protected $field__prompt_file_descriptor;
	protected $field__description;
	
	
	public function __construct(){
		$this->lock();
	}
	
	public static function create_from_POST_array($a_post_array){
		$ret_val = null;

		$this_class = get_class($this);
		$class_declared_fields = get_class_vars($this_class);
		
		$data = new prompt_to_accounts__VTO();
		foreach($class_declared_fields as $class_declared_field_name=>$value){
			$exists_in_post = key_exists($class_declared_field_name, $a_post_array);
			if($exists_in_post){
				$data->$class_declared_field_name = $a_post_array[$class_declared_field_name];
			}
				
		}
		
		$ret_val = $data;
		
		return $ret_val;
	}

	
}
