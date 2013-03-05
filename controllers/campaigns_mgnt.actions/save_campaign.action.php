<?php
require_once REALPATH .'/controllers/base.action.php';

class save_campaignAction extends baseAction {
	
	public function execute($a_command){
		
		require_once REALPATH .'/business_entities/campaign.BE.php';
		
		$posted_values = array_merge($_POST, $_FILES);
		
		$campaign = campaign__BE::create_from_POST_array($posted_values);
		
		$logo_file_descriptor = $campaign->logo; 
		$logo_file_tmp_path = $logo_file_descriptor["name"];
		$logo_file_name = basename($logo_file_tmp_path);
		$unique_prefix = uniqid();
		$logo_file_name = "{$unique_prefix}_{$logo_file_name}";
		
		$upload_dir = UPLOADDIR;
		$target_folder = "{$upload_dir}/campaigns__logos";
		$target_filename = $logo_file_name;
		
		$extention_array = array("jpg", "jpeg", "gif", "png", "bmp"); 
		
		require_once REALPATH ."/util/UploadHelper.php";
		$upload_helper = new UploadHelper();
		$move_file_ret_call = $upload_helper->move_file($logo_file_descriptor, $target_folder, $target_filename,$extention_array);
		
		if($move_file_ret_call->ret_code!=0){
			throw new Exception ($move_file_ret_call->ret_message);
		}
		
		$campaign->logo = $target_filename;
		
		$validation_result = $campaign->is_valid();
		$is_valid=$validation_result['is_valid'];
		
		if (!$is_valid){
			throw new Exception ('tás maluco');
		}
		
		
		$ola = $campaign->startDate;
		$ola = $campaign->endDate;
		
		$campaigns_repo = $this->get_repository_by_business_entity_name("campaign");
		/*
		$startDate_String = $campaign->startDate;
		$endDate_String = $campaign->endDate;
		
		
		$startDate = new DateTime($startDate_String);
		$endDate = new DateTime($endDate_String);
		
		*/
		
		
		$campaigns_repo->_store($campaign);
	}

}