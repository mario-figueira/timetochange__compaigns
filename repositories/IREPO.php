<?php


interface IREPO  {
	
	
	function get_by_id($a_business_entity_id);

	function store($a_business_entity_instance);

	function remove($a_business_entity_instance);
	
	
}
