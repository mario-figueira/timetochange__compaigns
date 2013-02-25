<?php

require_once __DIR__ ."/composed__base.BE.php";

class content_row__BE extends composed__base__BE {
	
	protected $cols;
	
	public function __construct($a_fields_array, $a_content, $a_cols_array){
		parent::__construct($a_fields_array, $a_content, "row");
		$this->cols = $a_cols_array;
	}
	
	public static function create_from_record($a_business_entity_record, $a_content, $a_cols_array){
		$ret_val = null;
		
		$instance = new self($a_business_entity_record, $a_content, $a_cols_array);
				
		$ret_val = $instance;
		
		return $ret_val;
	}	

}

?>