<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of default
 *
 * @author mfigueira
 */
class defaultTO__DOESNT_WORK__OBSOLET {

	public static function byArray__DOESNT_WORK($a_class_name, $a_values) {
		$constructor_method_descriptor = new ReflectionMethod($a_class_name,  '__construct');
		$constructor_arg_descriptors = $constructor_method_descriptor->getParameters(); 
		
		$args = array();
		foreach($constructor_arg_descriptors as $arg_descriptor){
			$arg_name = $arg_descriptor->name;
			$arg_full_descriptor = new ReflectionParameter(array($a_class_name, '__construct'), $arg_name );
			
			$arg_name = str_replace('a_', '', $arg_name);
			if(isset($a_values[$arg_name])){
				$arg_value = $a_values[$arg_name];
				$args[$arg_name] = $arg_value;
			}
		}
		
		$refClass = new ReflectionClass($a_class_name);
		$class_instance = $refClass->newInstanceArgs((array) $args); 
	}

}
?>
