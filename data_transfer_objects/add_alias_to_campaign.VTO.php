<?php

require_once __DIR__ . "/base.DTO.php";

class add_alias_to_campaign__VTO extends base__DTO{

	protected $campaign;
	protected $available_aliases;
	protected $available_prompts;
	protected $field__idCampaign;
	protected $field__idAlias;
	protected $field__alias;
	protected $field__idPromptIn;
	protected $field__idPromptOut;
	
	
	public function __construct(){
		$this->lock();
	}
	
	public static function create_from_POST_array($a_post_array){
		$ret_val = null;

		$this_class = get_class($this);
		$class_declared_fields = get_class_vars($this_class);
		
		$data = new add_alias_to_campaign__VTO();
		foreach($class_declared_fields as $class_declared_field_name=>$value){
			$exists_in_post = key_exists($class_declared_field_name, $a_post_array);
			if($exists_in_post){
				$data->$class_declared_field_name = $_POST[$class_declared_field_name];
			}
				
		}
		
		$ret_val = $data;
		
		return $ret_val;
	}

	
}
