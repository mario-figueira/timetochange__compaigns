<?php

require_once __DIR__ ."/content.BE.php";


class composed__base__BE extends content__BE {
	
	protected $content;

	public function __construct($a_fields_array, $a_content, $a_content_type){
		parent::__construct($a_fields_array, $a_content_type);
		$this->content = $a_content;
	}
	

}

?>