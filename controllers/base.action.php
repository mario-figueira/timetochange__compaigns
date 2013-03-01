<?php



abstract class baseAction {

	protected function get_repository_by_business_entity_name($a_entity_name){
		$ret_val = null;
				
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		$repo_factory = new repository__FACTORY();
		
		$repo = $repo_factory->get_repository_by_business_entity_name($a_entity_name);
		
		$ret_val = $repo;
		
		return $ret_val;

	}
	
	public abstract function execute($a_command);
			
}