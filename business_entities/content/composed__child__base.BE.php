<?php

require_once __DIR__ ."/../base.BE.php";


class composed__child__base__BE extends base__BE {
	
	protected $referenced_contents;
	
	public function __construct($a_fields_array){
		parent::__construct($a_fields_array);
	}
	
	public function get_referenced_content($a_name){
		$ret_val = null;
		
		$referenced_content = key_exists($a_name, $this->referenced_contents)?$this->referenced_contents[$a_name]:null;
		
		$ret_val = $referenced_content;
		
		return $ret_val;
	}

}

?>