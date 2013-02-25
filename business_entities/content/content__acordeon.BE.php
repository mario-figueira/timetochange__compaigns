<?php

require_once __DIR__ ."/composed__base.BE.php";


class content_acordeon__BE extends composed__base__BE {
	
	protected $sections;
	
	public function __construct($a_fields_array, $a_content, $a_sections_array){
		parent::__construct($a_fields_array, $a_content, "acordeon");
		$this->sections = $a_sections_array;
	}
	
	public static function create_from_record($a_business_entity_record, $a_content, $a_sections_array){
		$ret_val = null;
		
		$instance = new self($a_business_entity_record, $a_content, $a_sections_array);
				
		$ret_val = $instance;
		
		return $ret_val;
	}	

}
