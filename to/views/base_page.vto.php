<?php

class base_pageVTO extends defaultTO {

	protected $title;
	protected $sub_title;
	protected $image;

	function __set($name, $value) {
		if (property_exists($this, $name)) {
			if ('page_type' == $name) {
				DBCHelper2::assert_that()->the_param($value)->is_an_object_instance_of_the_class('page_typeTO');
			}
			$this->$name = $value;
		}
	}

	function __get($name) {
		if (property_exists($this, $name)) {
			return $this->$name;
		}
	}

}