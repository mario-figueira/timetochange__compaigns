<?php

require_once __DIR__ ."/../base.BE.php";

require_once "content_type.BE.php";

class content__BE extends base__BE {
	public $content_type;
	
	public function __construct($a_fields_array, $a_content_type){
		parent::__construct($a_fields_array);
		$this->content_type = $a_content_type;
		
	}
	
	public static function create_from_record($a_business_entity_record){
		$ret_val = null;
		
		$instance = new self($a_business_entity_record, $a_business_entity_record['type']);
				
		$ret_val = $instance;
		
		return $ret_val;
	}	
	
	public function is_active__get(){
		$ret_val = null;
		
		$is_active = $this->_get_field_value("is_active");
		
		$ret_val = $is_active;
		
		return $ret_val;
	}
	
	public function set_page_id($a_page_id){
		$this->_set_field_value("page_id", $a_page_id);
	}

	public function set_language_id($a_language_id){
		$this->_set_field_value("fk_language_id", $a_language_id);
	}
	
}

?>