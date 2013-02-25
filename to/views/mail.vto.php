<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ambassadorTO
 *
 * @author pmcosta
 */
require_once REALPATH . 'to/default.to.php';

class mailVTO extends defaultTO {
	
	protected $ambassador;
	
	//should be a comunity
	protected $community_name;
	protected $country_code;
	
	//these shold be acnhortos
	protected $command;
	protected $action;

	protected $rendering_in_a_web_browser;
	
	protected $activate_user_controller;
	protected $activate_user_action;
	
	protected $images;
	//these could be imgvto
	protected $email_topo_img_filename;
	protected $email_logo_img_url;
	
	protected $activate_user_url;
	//this should be in english and a have a simplified build process
	//Collection of strings
	protected $hello;
	protected $obrigado_pelo_tempo_str;
	protected $estas_apenas_a_um_passo_str;
	protected $para_terminar_clica_str;
	protected $link_de_activacao_str;
	protected $aproveita_e_activa_str;
	protected $obrigado_str;
	protected $members_mail_address;
	
	function __construct($a_array = null, $a_boolean_ignore_extra = false) {
		parent::__construct($a_array, $a_boolean_ignore_extra);
	}

	public function add_image($a_image_vto){
		$valid_object_type = ($a_image_vto instanceof imageVTO);
		if($valid_object_type){
			$this->images[] = $a_image_vto;
		}else{
			throw new Exception('invalid argument $a_image_vto type['.  get_class($a_image_vto).'] is not instance of image_vto ' . $name);
		}
	}
	
	public function __set($name, $value) {
		if (!property_exists($this, $name)) {
			throw new Exception('Propety doesn not exist' . $name);
		}
		switch ($name) {
			case 'ambassador':
				$this->set_ambassador($value);
				break;
			case 'images':
				throw new Exception('invalid way to set images use add_image');
			default:
				$this->$name = $value;
				break;
		}
	}

	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}

	private function set_ambassador($a_ambassador_to) {
		require_once 'to/ambassador.to.php';
		if ($a_ambassador_to instanceof ambassadorTO) {
			$this->ambassador = $a_ambassador_to;
		} else {
			throw new Exception('$a_ambassador_to [' . get_class($a_ambassador_to) . '] is not a ambassadorTO');
		}
	}

}

?>
