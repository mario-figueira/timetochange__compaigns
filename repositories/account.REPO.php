<?php

require_once __DIR__ ."/base.REPO.php";

require_once __DIR__ ."/IREPO.php";

class account__REPO extends base__REPO {	
	
	public function __construct($a_business_entity){
		parent::__construct($a_business_entity);		
	}
	
	public function get_by_id($a_business_entity_id){
		
		$ret_val = null;

		$record = parent::get_record_by_id($a_business_entity_id);
		
		require_once REALPATH ."/business_entities/account.BE.php";
		
		$instance =  account__BE::create_from_record($record);
		
		$ret_val = $instance;
		
		return $ret_val;
		
	}
	
	public function all__get(){
		
		$records = array(
			array("id"=>"1", "name"=>"account1")
			,array("id"=>"2", "name"=>"account 2")
		);
		
		$account_dao = $this->get_default_dao_by_table_name("account");
		
		$records = $account_dao->get_all();
		
		require_once REALPATH ."/business_entities/account.BE.php";
		
		$ret_val = array();
		
		foreach($records as $record){			
			$account_instance = account__BE::create_from_record($record);
			$ret_val[] = $account_instance;
			
		}
		
		return $ret_val;
		
		
		
	}
	
	
	public function users_of_account__get_by_account($a_account){
		$ret_val = array();
		
		$useraccountrule_dao = $this->get_default_dao_by_table_name("useraccountrole");
		
		$account_id = $a_account->id;
		$account_users_records = $useraccountrule_dao->get_records_by_filter(array("idAccount"=>$account_id));

		require_once REALPATH ."/repositories/repository.FACTORY.php";
		$repo_factory = new repository__FACTORY();
		
		$users_repo = $repo_factory->get_repository_by_business_entity_name("user");
		$roles_repo = $repo_factory->get_repository_by_business_entity_name("role");

		require_once REALPATH ."/value_objects/account_user.VO.php";
		$account_users = array();
		foreach ($account_users_records as $account_user_record){
			$user_id = $account_user_record['idUser'];
			$user = $users_repo->get_by_id($user_id);

			$role_id = $account_user_record['idAccountRole'];
			$role = $roles_repo->get_by_id($role_id);
			
			$account_user = account_user__VO::create($account_user_record, $a_account, $user, $role);
			
			$account_users[] = $account_user;
		}
		
		$ret_val = $account_users;
		
		return $ret_val;
	}
	
	public function alias_of_account__get_by_account($a_account){
		$ret_val = array();
		
		$accountalias_dao = $this->get_default_dao_by_table_name("accountaliases");
		
		$account_id = $a_account->id;
		$account_aliases_records = $accountalias_dao->get_records_by_filter(array("idAccount"=>$account_id));

		require_once REALPATH ."/repositories/repository.FACTORY.php";
		$repo_factory = new repository__FACTORY();
		
		$alias_repo = $repo_factory->get_repository_by_business_entity_name("alias");

		require_once REALPATH ."/value_objects/account_alias.VO.php";
		$account_aliases = array();
		foreach ($account_aliases_records as $account_alias_record){
			$alias_id = $account_alias_record['idAlias'];
			$alias = $alias_repo->get_by_id($alias_id);

			
			$account_alias = account_alias__VO::create($account_alias_record, $a_account, $alias);
			
			$account_aliases[] = $account_alias;
		}
		
		$ret_val = $account_aliases;
		
		return $ret_val;
	}	
	
	public function add_user_to_account($a_user_id, $a_account_id, $a_role_id){
		$useraccountrule_dao = $this->get_default_dao_by_table_name("useraccountrole");
		
		$data_to_persist = array('idAccount'=>$a_account_id, 'idAccountRole'=>$a_role_id, 'idUser'=>$a_user_id, 'isInvited'=>false);
		
		$useraccountrule_dao->persist($data_to_persist);

		
	}
	
	

}
