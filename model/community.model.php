<?php

require_once'default.model.php';
require_once 'util/TextUtil.php';
require_once 'util/Logger.php';

class communityModel extends defaultModel {

	
    function __construct() {
		parent::__construct('community');
	}

	function getFisrtByDomain() {
		$community = parent::getFilteredBy(array('domain' => str_replace('www.', '', $_SERVER['HTTP_HOST'])), false);
		return $community;
	}

	function get_comunities_with_countries() {
		$result = null;
		$communities = $this->get_all();
		require_once 'model/countries.model.php';
		$countries_model = new countriesModel();

		foreach ($communities as $community) {
			$community['country_info'] = $countries_model->getById($community['fk_aux_countries_id']);
			require_once 'model/site.model.php';
			$site_model = new siteModel();
			$site_model->getFilteredBy(array('fk_community_id', $community['id']));
			$result[] = $community;
		}
		return $result;
	}

	function get_by_country_id($country_id) {
		$community = parent::getFilteredBy(array('fk_aux_countries_id' => $country_id));
		return $community;
	}

	function getByDomain($domain) {
		$community = parent::getFilteredBy(array('domain' => str_replace('www.', '', $_SERVER['HTTP_HOST'])));
		return $community;
	}

	function getByDomainAndName($domain, $name) {
		$community = parent::getFilteredBy(array('domain' => str_replace('www.', '', $_SERVER['HTTP_HOST']), 'name' => $name), false);
		return $community;
	}

	function getactive_site($id) {
		return parent::getFilteredBy(array('domain' => str_replace('www.', '', $_SERVER['HTTP_HOST'])));
	}
	
	
	
	
/*  CONFIRMED IN USE METHODS */
	
	public function get_available_communities_to_choose_from(){
		$ret_val = array();
		
		$values = array();
		
            $query = "
                    SELECT com.*, site.domain as url
			  FROM 
				community com
				, site site
				, aux_countries ctry
				, aux_languages lang
			  WHERE 1=1
			    AND site.fk_community_id = com.id
			    AND ctry.id = com.fk_aux_countries_id
			    AND lang.id = fk_default_language_id
			    AND com.is_active = 1
			    AND site.is_active = 1
			  ORDER BY com.display_order";
		
            $this->connect();

            $sqlResult = $this->mysql_query($query);
            $mysql_errors = mysql_error();

		while ($record = $this->mysql_fetch_assoc($sqlResult)) {
			$records[] = $record;
		}
		
		$this->disconnect();
		
		$ret_val = $records;
		
		
		return $ret_val;
	}
	

}
