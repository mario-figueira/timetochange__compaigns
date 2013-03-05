<?php
require_once REALPATH .'/controllers/base.action.php';

class save_accountAction extends baseAction {
	
	public function execute($a_command){
		
		require_once REALPATH .'/business_entities/account.BE.php';
		
		$posted_values = array_merge($_POST, $_FILES);
		
		$account = account__BE::create_from_POST_array($posted_values);
		
		$logo_file_descriptor = $account->logo; 
		$logo_file_tmp_path = $logo_file_descriptor["name"];
		$logo_file_name = basename($logo_file_tmp_path);
		$unique_prefix = uniqid();
		$logo_file_name = "{$unique_prefix}_{$logo_file_name}";
		
		$upload_dir = UPLOADDIR;
		$target_folder = "{$upload_dir}/accounts__logos";
		$target_filename = $logo_file_name;
		
		$extention_array = array("jpg", "jpeg", "gif", "png", "bmp"); 
		
		require_once REALPATH ."/util/UploadHelper.php";
		$upload_helper = new UploadHelper();
		$upload_helper->move_file($logo_file_descriptor, $target_folder, $target_filename,$extention_array);
		
		$account->logo = $target_filename;
		
		$validation_result = $account->is_valid();
		$is_valid=$validation_result['is_valid'];
		
		if (!$is_valid){
			throw new Exception ('tás maluco');
		}
		
		
		$accounts_repo = $this->get_repository_by_business_entity_name("account");
		
		$accounts_repo->_store($account);
	}

}