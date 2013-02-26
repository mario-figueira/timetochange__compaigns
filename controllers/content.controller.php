<?php

class contentController {

	private function get_active_language_record() {

		$ret_val = null;

		require_once REALPATH .'model/default.model.php';
		$aux_languages_model = new defaultModel('aux_languages');
			
		if (isset($this->Command->Parameters['active_site'])) {
			$active_site = $this->Command->Parameters['active_site'];
			$active_site_default_language = $active_site['fk_default_language_id'];
			Logger::debug($this, "got active site default language id=[$active_site_default_language].");
			$active_site_id = $active_site['id'];
			Logger::debug($this, "getting language record for the default language (language=[$active_site_default_language]) of the active site(id=[$active_site_id]).");
			$language = $aux_languages_model->getById($active_site_default_language);
		} else {
			$language = $aux_languages_model->getById(1); //TODO for now english is the default LANGUAGE
		}

		$ret_val = $language;

		return $ret_val;
	}

	protected function load_active_site() {
		
		$active_site = array();
		$active_site['id'] = 1;
		$active_site['name'] = "default";
		$active_site['fk_default_language_id'] = 1;
		$active_site['domain'] = BASEPATH;
		
		$this->Command->set_active_site($active_site);
	}

	protected function load_default_css() {

		$this->Command->Parameters['css'][] = "css/reset.css{$timestamp}";
		$this->Command->Parameters['css'][] = "js/jsjquery-ui-1.8.23.custom_allmodules/css/ui-lightness/jquery-ui-1.8.23.custom.css{$timestamp}";
		$this->Command->Parameters['css'][] = "js/tinybox2/style.css{$timestamp}";
		$this->Command->Parameters['css'][] = "css/stylesheet.css{$timestamp}";
		
	}

	protected function load_default_js() {
		if (!BACKOFFICE) {
			$jsArray[] = "js/jquery-1.7.1.min.js";
			$jsArray[] = 'js/tinybox2/tinybox.js';
			$jsArray[] = 'js/jquery.form.js';
			$jsArray[] = "js/jquery.validate.min.js";
			$jsArray[] = "js/jsjquery-ui-1.8.23.custom_allmodules/js/jquery-ui-1.8.23.custom.min.js";
			//$jsArray[] = "js/jquery.json-2.3.min.js";
//            if (isset($this->Command->Parameters['country']['encoding'])) {
//
//			$jsArray[] = "js/jquery-validation-1.9.0/localization/messages_" . strtolower($this->Command->Parameters['country']['encoding']) . ".js";
//			
//
//            }

			$active_language = $this->get_active_language_record();
			$language_idiom_code = $active_language['short'];
			$localizaed_jquery_validation_file = "js/jquery-validation-1.9.0/localization/messages_" . $language_idiom_code . ".js";
			$jsArray[] = $localizaed_jquery_validation_file;

			//$jsArray[] = "js/jquery.validate.jform.js";
			$jsArray[] = "js/wom.js";
			$jsArray[] = "js/less-1.3.0.min.js";
		} else {
			$jsArray[] = 'js/libs/jquery-1.7.1.min.js';
			$jsArray[] = 'js/libs/modernizr-2.5.3.min.js';
			$jsArray[] = 'js/tinybox2/tinybox.js';
			$jsArray[] = 'js/jquery.form.js';
			$jsArray[] = "js/jquery.validate.jform.js";
			$jsArray[] = "js/jsjquery-ui-1.8.23.custom_allmodules/js/jquery-ui-1.8.23.custom.min.js";
		}
		$this->Command->Parameters['js'] = $jsArray;
	}
	
}

?>