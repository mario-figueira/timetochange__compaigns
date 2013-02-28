<?php

require_once 'controllers/default.controller.php';

class helloController extends defaultController {

	public function _default() {
		parent::_default();
	}

	public function _world() {
		Logger::debug($this, '_default(' . $id . ') PARAMETERS [' . print_r($this->Command->get_parameters(), true) . ']');
		
		//$this->force_user_is_loggedin();

		//DBCHelper2::require_that()->the_param($a_campaign_layout)->is_an_array();

	
		
		//require_once REALPATH .'enums/page_type.php';
		require_once(REALPATH . 'model/default.model.php');
		$model = new defaultModel('app___hello_world');
		$all_records = $model->get_all();
		
		$string_to_print = "";
		foreach($all_records as $record){
			$string_to_print .= $record['string_to_display'];
		}


		$this->Command->add_js('js/SpryAccordion.js');
		$this->Command->add_js('css/SpryAccordion.css');
		
		//$this->Command->set_parameter('string_to_print', $string_to_print);
		
		$this->Command->set_parameter('string_to_print', $string_to_print);
		parent::_defaultAction();
		

	}
	
	public function _code_snippets() {
		Logger::debug($this, '_default(' . $id . ') PARAMETERS [' . print_r($this->Command->get_parameters(), true) . ']');
		//$current_ambassador_id = $this->get_current_ambassador_id();
		
		//$this->force_user_is_loggedin();

		//DBCHelper2::require_that()->the_param($a_campaign_layout)->is_an_array();


		
		
		//require_once REALPATH .'enums/page_type.php';
		//require_once(REALPATH . 'model/ambassador.model.php');

		// $this->Command->get_controller_name();

		//$this->Command->set_parameter('ajax', 1);

		$this->Command->add_js('js/SpryAccordion.js');
		$this->Command->add_css('css/SpryAccordion.css');
		
		$this->Command->set_parameter('string_to_show', "Hello world!");
		
		//$this->Command->set_action($this->Command->get_action() . ".fo.current");
		
		/*
			$this->Template = new Template($this->Command);
			$this->Template = new Template(new Command($this->Command->get_controller_name(), $retCall->template_name));
		 * 
			$this->Template->set('current_page', $page);
			$this->Template->set_parameters($this->Command->get_parameters());
			$this->Template->override_controller('components');
			$this->Template->override_action('html/select');
		 		 
			$this->Template->render();render
		 */
		parent::_defaultAction();
		
		//header("Location:" . BASEPATH . $this->Command->Parameters["country"]['name'] . "/profile");

		try{
		} catch (Exception $e) {
			$msg = $e->getMessage();
			$trace = $e->getTraceAsString();

			Logger::exception($this, $e);			
			$this->_error();
		}


	}
	
}