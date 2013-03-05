<?php

class UploadHelper {

	public function move_file($a_tmp_file_descriptor, $a_target_folder, $a_target_file_name, $a_allowed_extensions=array()){
	
		DBCHelper2::require_that()->the_param($a_allowed_extensions)->is_an_array();
		
		$ret_val = new stdClass();
		$ret_val->ret_code = 0;
		$ret_val->ret_message = "sucess";
		
		$file_parts = explode('.', $a_target_file_name);
		$file_part_length = sizeof($file_parts);
		$extention = $file_parts[$file_part_length-1];
		
		$is_good_to_move = false;
		$there_area_extensions_to_validate_against= sizeof($a_allowed_extensions)>0;
		$is_in_the_array_of_allowed_extensions =false;
			
		
		if ($there_area_extensions_to_validate_against){
			$is_in_the_array_of_allowed_extensions=in_array($extention, $a_allowed_extensions);
			if(!$is_in_the_array_of_allowed_extensions){
				$ret_val->ret_code = 5;
				$ret_val->ret_message = "extension not allowed";
				goto l_exit;
			}
			else{
				//$is_good_to_move = true; 
			}
		}
		else{
			//$is_good_to_move = true; 	
		}
		
		
		//so move it

		$tmp_file_path = $a_tmp_file_descriptor["tmp_name"];

		$target_file_path = "{$a_target_folder}/{$a_target_file_name}";
		try{
			$move_uploaded_file_call_ret = move_uploaded_file($tmp_file_path, $target_file_path);
		}
		catch(Exception $e){
			$ret_val->ret_code = 10;
			$ret_val->ret_message = $e->getMessage();
			goto l_exit;
		}

		if(!$move_uploaded_file_call_ret){
			$ret_val->ret_code = 20;
			$ret_val->ret_message = "uploaded file cannot be moved";
			goto l_exit;
		}
		
		
		$ret_val->ret_code = 0;
		$ret_val->ret_message = "sucess";	

l_exit:	
		return $ret_val;
		
	}
	

}

