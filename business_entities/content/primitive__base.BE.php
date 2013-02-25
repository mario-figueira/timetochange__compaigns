<?php

require_once __DIR__ ."/content.BE.php";


class primitive__base__BE extends content__BE {
	
	protected $content;
	
	public function __construct($a_fields_array, $a_content_type){
		parent::__construct($a_fields_array, $a_content_type);
	}
	
	public function get_value(){
		$ret_val = null;
		
		$value = $this->_base_fields['value'];
		
		$ret_val = $value;
		
		return $ret_val;
	}
		
	public function get_raw_value(){
		$ret_val = null;
		
		$value = $this->_base_fields['value'];
		
		$ret_val = $value;
		
		return $ret_val;
	}
	
	public function set_raw_value($a_raw_value){
		
		$this->_base_fields['value'] = $a_raw_value;
		
	}


}

?>