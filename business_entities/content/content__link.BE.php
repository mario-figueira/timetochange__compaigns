<?php

require_once __DIR__ ."/primitive__base.BE.php";

class content_link__BE extends primitive__base__BE {
	
	protected $content;
	
	public function __construct($a_fields_array, $a_content){
		parent::__construct($a_fields_array, "link");
		$this->content = $a_content;
	}
	
	public static function create_from_record($a_business_entity_record, $a_content){
		$ret_val = null;
		
		$instance = new self($a_business_entity_record, $a_content);
				
		$ret_val = $instance;
		
		return $ret_val;
	}	

}

?>