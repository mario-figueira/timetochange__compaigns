<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of defaultTO
 *
 * @author pmcosta
 */
class defaultTO {

    //put your code here

    function __construct($a_array = null, $a_boolean_ignore_extra = false) {
        if(is_array($a_array)){
            foreach ($a_array as $key => $value) {
                if (property_exists($this, $key)) {
			   if (isset($value)) {
                        $this->$key = $value;
                    }
                } else if ($a_boolean_ignore_extra) {
                    Logger::debug($this, 'GOT invalid or empty property[' . $key . '] for[' . get_class($this) . ']');
                } else {
                    throw new Exception('GOT invalid property[' . $key . '] for[' . get_class($this) . ']');
                }
            }
        }
    }

    public function update_by_to($a_ambassador) {
        if ($a_ambassador instanceof ambassadorTO) {
            $array_ambassador = $a_ambassador->get_as_array();
            $this->update_by_array($array_ambassador);
        } else {
            throw new Exception("Trying to update ambassador TO with " . get_class($a_ambassador));
        }
    }

    public function update_by_array($a_array) {
        foreach ($a_array as $key => $value) {
            if (!empty($value)) {
                $this->$key = $value;
            }
        }
    }

    public function get_as_array() {
        $result = array();
        $array = get_object_vars($this);
        foreach ($array as $key => $value) {
            if (!empty($value)) {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    
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
    
    public function __toString() {
	    $result = print_r($this,TRUE);
	    return $result;
    }
}

?>
