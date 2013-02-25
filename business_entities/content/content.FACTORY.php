<?php


require_once "content_type.ENUM.php";

class content__FACTORY  {
		
	public function __construct(){
		
	}

	public function new_object(content_type__ENUM $a_type){
		$ret_val = null;
		
		switch ($a_type) {
			
			case content_type__ENUM::$IMG:
				require_once "content__img.BE.php";
				$ret_val = new content__acordeon__BE();
				break;
			
			case content_type__ENUM::$ACORDEON:
				require_once "content__acordeon.BE.php";
				$ret_val = new content__acordeon__BE();
				break;
			
			default:
				break;
		}
	}
	

}
