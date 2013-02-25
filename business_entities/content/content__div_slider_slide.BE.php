<?php

require_once __DIR__ ."/composed__child__base.BE.php";


class content_div_slider_slide__BE extends composed__child__base__BE {
	
	protected $referenced_contents;
	
	public function __construct($a_fields_array, $a_referenced_contents_array){
		parent::__construct($a_fields_array);
		$this->referenced_contents = $a_referenced_contents_array;
	}
	
	public static function create_from_record($a_business_entity_record, $a_referenced_contents_array){
		$ret_val = null;
		
		$instance = new self($a_business_entity_record, $a_referenced_contents_array);
				
		$ret_val = $instance;
		
		return $ret_val;
	}	

}
