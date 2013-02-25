<?php

z_localization_main();

	function z_localization_main(){
            try{
		$strings_to_translate = array();

		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- aux_countries_phone_validation_rules -----');
		$new_strings = z_localization_aux_countries_phone_validation_rules_get_strings_to_translate();	
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);

		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');

		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- aux_employment_situation -----');
		$new_strings = z_localization_aux_employment_situation_get_strings_to_translate();
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);

		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');

                /* 
                 * TODO Reg_ex np tranlation
                 */
                
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- aux_countries_zipcode_validation_rules -----');
		$new_strings = z_localization_aux_countries_zipcode_validation_rules_get_strings_to_translate();
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);
		
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');

		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- aux_buy_products -----');
		$new_strings = z_localization_aux_buy_products_get_strings_to_translate();
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);
		
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');

		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- aux_interests -----');
		$new_strings = z_localization_aux_interests_get_strings_to_translate();
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);
		
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');

		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- aux_new_products -----');
		$new_strings = z_localization_aux_new_products_get_strings_to_translate();
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);
		
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');

		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- aux_professions -----');
		$new_strings = z_localization_aux_professions_get_strings_to_translate();
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);
		
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- aux_relationship_decision -----');
		$new_strings = z_localization_aux_relationship_decision_get_strings_to_translate();
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);
		
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- aux_social_networks -----');
		$new_strings = z_localization_aux_social_networks_get_strings_to_translate();
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);
		
		
		//$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		//$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		// ESTAS traduções são feitas directamente na Base de Dados
		//$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- survey_questions -----');
		//$new_strings = z_localization_survey_questions_get_strings_to_translate();
		//z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);
		
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		
		/*
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- survey_page -----');
		$new_strings = z_localization_survey_page_get_strings_to_translate();
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);
		*/
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- page -----');
		$new_strings = z_localization_page_get_strings_to_translate();
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);
		
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- aux_gender -----');
		$new_strings = z_localization_aux_gender_get_strings_to_translate();
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);

		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- aux_marital_status -----');
		$new_strings = z_localization_aux_marital_status_get_strings_to_translate();
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);
		
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- aux_schooling -----');
		$new_strings = z_localization_aux_schooling_status_get_strings_to_translate();
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);
		
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'');
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- aux_yes_no -----');
		$new_strings = z_localization_aux_yes_no_status_get_strings_to_translate();
		z_localization_add_array_items_to_another_array($new_strings, $strings_to_translate);
		
		$strings_to_translate[] = array('type'=>'comment', 'value'=>'----- C_EMPTY_VALUE_MESSAGE_FOR_MULTIPLE_CHOICES -----');
		$more_strings[] = array();
		require_once REALPATH ."model/survey_questions.model.php";
		$more_strings[] = survey_questionsModel::$C_EMPTY_VALUE_MESSAGE_FOR_MULTIPLE_CHOICES;
		z_localization_add_array_items_to_another_array($more_strings, $strings_to_translate);
		
		z_localization_write_string_to_translate_to_file($strings_to_translate, "strings_to_translate.php");

            }  catch (Exception $e){
                throw $e;
            }
                
       }
	
// ------------------------ functions ------------------------------	
	function z_localization_aux_countries_phone_validation_rules_get_strings_to_translate (){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('aux_countries_phone_validation_rules');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['validation_msg'];
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
	function z_localization_aux_countries_zipcode_validation_rules_get_strings_to_translate (){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('aux_countries_zipcode_validation_rules');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['validation_msg']; //pmcosta alterado coluna não existe
                  //$string_to_translate = $record['validation_reg_ex']; //pmcosta alterado coluna existe
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
	function z_localization_aux_employment_situation_get_strings_to_translate (){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('aux_employment_situation');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['printable_name'];
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
	function z_localization_aux_buy_products_get_strings_to_translate(){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('aux_buy_products');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['printable_name'];
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
	function z_localization_aux_interests_get_strings_to_translate(){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('aux_interests');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['printable_name'];
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
	function z_localization_aux_new_products_get_strings_to_translate(){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('aux_new_products');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['printable_name'];
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
	function z_localization_aux_professions_get_strings_to_translate(){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('aux_professions');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['printable_name'];
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
	function z_localization_aux_relationship_decision_get_strings_to_translate(){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('aux_relationship_decision');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['printable_name'];
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
	function z_localization_aux_social_networks_get_strings_to_translate(){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('aux_social_networks');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['printable_name'];
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
	function z_localization_survey_questions_get_strings_to_translate(){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('survey_questions');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['question'];
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
	function z_localization_survey_page_get_strings_to_translate(){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('survey_page');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['display_text'];
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
	function z_localization_page_get_strings_to_translate(){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('page');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['printable_name'];
			if(key_exists($string_to_translate, $strings_to_translate)){
				continue;				
			}
			$strings_to_translate[$string_to_translate] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
	function z_localization_aux_gender_get_strings_to_translate(){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('aux_gender');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['printable_name'];
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}

	function z_localization_aux_marital_status_get_strings_to_translate(){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('aux_marital_status');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['printable_name'];
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
	function z_localization_aux_schooling_status_get_strings_to_translate(){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('aux_schooling');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['printable_name'];
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
	function z_localization_aux_yes_no_status_get_strings_to_translate(){
		$strings_to_translate = array();
		
		require_once "model/default.model.php";
		$model = new defaultModel('aux_yes_no');
		$records = $model->get_all();
		foreach($records as $record){
			$string_to_translate = $record['printable_name'];
			$strings_to_translate[] = $string_to_translate;
		}
		
		return $strings_to_translate;
	}
	
// ------------------------ low level functions ------------------------------	
	
	function z_localization_add_array_items_to_another_array($a_source_array, &$a_target_array){
		foreach($a_source_array as $source_array_item){
			$a_target_array[] = array('type'=>'string_to_translate', 'value'=>$source_array_item);
		}			
	}
	
	
	function  z_localization_write_string_to_translate_to_file($a_strings_to_translate, $a_file){
	
		$myFile = $a_file;
		$fh = fopen($myFile, 'w') or die("can't open file ".$myFile." (Translations)");
		fwrite($fh, "<?php \n");
		foreach($a_strings_to_translate as $record){
			
			$type = $record['type'];
			$string_to_translate = $record['value'];
			if($type=='string_to_translate'){ 
				$string_to_translate = str_replace("'", "\'", $string_to_translate);
				$string_to_translate = "echo _('$string_to_translate'); \n";
			}  else {
				$string_to_translate = "// $string_to_translate \n";
			}
			
			fwrite($fh, $string_to_translate);
		}
		fwrite($fh, " ?> \n");
		fclose($fh);
	}
	
	

?>