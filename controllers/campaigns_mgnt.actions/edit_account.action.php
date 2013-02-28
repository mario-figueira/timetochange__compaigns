<?php


class edit_accountAction {
	
	public function execute($a_command){
		require_once REALPATH ."/repositories/repository.FACTORY.php";
		
		$selected = $_POST['selected'];
		
		$no_selected_accounts = !isset($selected);
		if($no_selected_accounts){
			return;
		}
		
		$account_id_to_edit = $selected[0];

		
		$repo_factory = new repository__FACTORY();
		
		$accounts_repo = $repo_factory->get_repository_by_business_entity_name("account");
		
		$account = $accounts_repo->get_by_id($account_id_to_edit);

		
		$a_command->set_parameter("account",$account);
		
		
		$repo_factory = new repository__FACTORY();
		
		$countries_repo = $repo_factory->get_repository_by_business_entity_name("country");
		
		$all_countries = $countries_repo->all__get();
		
		$a_command->set_parameter("countries",$all_countries);
				
	}

}