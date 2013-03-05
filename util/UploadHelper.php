<?php

class UploadHelper {

	public function move_file($a_tmp_file_descriptor, $a_target_folder, $a_target_file_name, $a_allowed_extensions=array()){
	
		$ret_val = null;
		
		
		$tmp_file_path = $a_tmp_file_descriptor["tmp_name"];
		
		$target_file_path = "{$a_target_folder}/{$a_target_file_name}";
		$ret_val = move_uploaded_file($tmp_file_path, $target_file_path);
		
		return $ret_val;
		
	}
	

}

