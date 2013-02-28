<?php

require_once 'controllers/default.controller.php';

class helloController extends defaultController {

	public function _default() {
		parent::_default();
	}

	public function _world() {
		Logger::debug($this, '_default(' . $id . ') PARAMETERS [' . print_r($this->Command->Parameters, true) . ']');
		
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


		$this->Command->Parameters['js'][] = 'js/SpryAccordion.js';
		$this->Command->Parameters['css'][] = 'css/SpryAccordion.css';
		
		//$this->Command->Parameters['string_to_print']  = $string_to_print;
		
		$this->Command->set_parameter('string_to_print', $string_to_print);
		parent::_defaultAction();
		

	}
	
	public function _code_snippets() {
		Logger::debug($this, '_default(' . $id . ') PARAMETERS [' . print_r($this->Command->Parameters, true) . ']');
		//$current_ambassador_id = $this->get_current_ambassador_id();
		
		//$this->force_user_is_loggedin();

		//DBCHelper2::require_that()->the_param($a_campaign_layout)->is_an_array();


		
		
		//require_once REALPATH .'enums/page_type.php';
		//require_once(REALPATH . 'model/ambassador.model.php');

		// $this->Command->getControllerName();

		//$this->Command->Parameters['ajax'] = 1;

		$this->Command->Parameters['js'][] = 'js/SpryAccordion.js';
		$this->Command->Parameters['css'][] = 'css/SpryAccordion.css';
		
		$this->Command->Parameters['string_to_show']  = "Hello world!";
		
		//$this->Command->set_action($this->Command->getAction() . ".fo.current");
		
		/*
			$this->Template = new Template($this->Command);
			$this->Template = new Template(new Command($this->Command->getControllerName(), $retCall->template_name));
		 * 
			$this->Template->set('current_page', $page);
			$this->Template->setParameters($this->Command->Parameters);
			$this->Template->overideController('components');
			$this->Template->overideAction('html/select');
		 		 
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