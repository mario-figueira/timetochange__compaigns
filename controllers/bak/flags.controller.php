<?php

include_once 'controllers/default.controller.php';

class flagsController extends defaultController {

	function __construct(&$command) {
		Logger::debug($this, '__contruct(' . $command . ')');

		require_once REALPATH . 'router/wom_ambassadors_command.php';
		$new_specific_command = new wom_ambassadors_command(
				    $command->Name
				    , $command->Action
				    , $command->Parameters
		);
		$this->Command = $new_specific_command;
		/*
		require_once REALPATH.'model/community.model.php';
		$comunity_model = new communityModel();
		$command->Parameters['community'] = $comunity_model->getById(4);
		// TODO create methos getdefault comunity
		
		require_once REALPATH.'model/countries.model.php';
		$countries_model = new countriesModel();
		$command->Parameters['country'] = $countries_model->getById('GR');
		// TODO create methos getdefault comunity
		
		
		require_once 'model/site.model.php';
		$site_model = new siteModel();
		$active_site = $site_model->getById(94);
		$active_site['domain'] = 
		 */
		$this->Command->Parameters['active_site']['domain'] = "http://" .$_SERVER['HTTP_HOST'];;
		
		$this->load_default_css();
		$this->load_default_js();
		//parent::__construct($command);
	}

	function _default() {
		Logger::debug($this, '_default() PARAMETERS [' . print_r($this->Command->Parameters, true) . ']');

		// redirect to _show
		$this->_show();
	}

	function _show() {
		Logger::debug($this, '_show() PARAMETERS [' . print_r($this->Command->Parameters, true) . ']');
		//Model operations

		require_once 'model/community.model.php';
		$community_model = new communityModel();

		$available_communities = $community_model->get_available_communities_to_choose_from();
		$this->Command->Parameters['available_communities_to_choose_from'] = $available_communities;

		$this->Template = new Template($this->Command);
		$this->Template->render();
	}

	public function execute() {
		$this->_show();
	}
	
	public function load_default_js(){
		$this->Command->Parameters['js'] = array();
	}
}
