<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ambassador
 *
 * @author mfigueira
 */
class ambassador {

	var $id;

	public function __construct($a_id) {
		$this->id = $a_id;
	}

	public static function byArray($values) {
		$instance = null;
		$instance = new self($values['id']);
		return $instance;
	}

}

?>
