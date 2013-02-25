<?php

require_once 'util/DBCHelper.php';

class repository__FACTORY  {
	
	public function __construct(){
		
	}
	
	public function get_repository_by_business_entity_name($a_business_entity_name){
		DBCHelper2::require_that()->the_param($a_business_entity_name)->is_a_string();
		
		$ret_val = null;
		
		$instantiated_repository = null;
		$business_entity_name = strtolower($a_business_entity_name);
		
		switch ($a_business_entity_name) {
			
			case"content":
				$repository_php_file =  __DIR__ ."/content/content.REPO.php";
				$repository_class_to_instantiate = "content__REPO";								
				
				$instantiated_repository = $this->build_concrete_respository(
					$repository_php_file
					, $repository_class_to_instantiate
					, $business_entity_name
				);
				
				break;

			default:
				$repository_php_file =  __DIR__ ."/{$business_entity_name}.REPO.php";
				$repository_class_to_instantiate = "{$business_entity_name}__REPO";								
				
				if(file_exists($repository_php_file)){
				
					$instantiated_repository = $this->build_concrete_respository(
						$repository_php_file
						, $repository_class_to_instantiate
						, $business_entity_name
					);
				}
				else{
					$instantiated_repository = $this->build_default_respository(
						$business_entity_name
					);
				}
				
				break;
		}
		
		$ret_val = $instantiated_repository;
		
		return $ret_val;
	}
	
	private function build_concrete_respository(
		$a_concrete_repository_php_file
		, $repository_class_name_to_instantiate
		, $a_business_entity_name
	){
		
		$ret_val = null;

		DBCHelper2::assert_that()->the_file($a_concrete_repository_php_file)->exists();

		require_once $a_concrete_repository_php_file;

		DBCHelper2::assert_that()->the_class($repository_class_name_to_instantiate)->exists();

		$instantiated_repository = new $repository_class_name_to_instantiate($a_business_entity_name);			

		$ret_val = $instantiated_repository;
		
		return $ret_val;
	}
	
	private function build_default_respository(
		$a_business_entity_name
	){
		$ret_val = null;
		
		$default_repository_php_file = "default.REPO.php";
		
		require_once $default_repository_php_file;
		
		$instantiated_repository = new default__REPO($a_business_entity_name);
		
		$ret_val = $instantiated_repository;
		
		return $ret_val;
	}
}


class repository_class_doesnt_exists extends Exception{
	public $repository_class;
	
	public function __construct($a_repository_class){
		$this->repository_class = $a_repository_class;
	}
}
