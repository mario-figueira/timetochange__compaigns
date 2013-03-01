<?php
require_once REALPATH .'/controllers/base.action.php';

class edit_accountAction extends baseAction {
	
	public function execute($a_command){
		
		$selected = $_POST['selected'];
		
		$no_selected_accounts = !isset($selected);
		if($no_selected_accounts){
			return;
		}
		
		$account_id_to_edit = $selected[0];

		
		
		$accounts_repo = $this->get_repository_by_business_entity_name("account");
		
		$account = $accounts_repo->get_by_id($account_id_to_edit);

		
		$a_command->set_parameter("account",$account);
		
		
		
		$countries_repo = $this->get_repository_by_business_entity_name("country");
		
		$all_countries = $countries_repo->all__get();
		
		$a_command->set_parameter("countries",$all_countries);
				
	}

}