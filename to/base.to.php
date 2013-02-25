<?php

class baseTO {

    function __construct($args) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key)) {
                $this->__set($key, $value);
            } else {
                //throw new Exception('Invalid args ['.$args.'] for '.get_class($this).' no properrty '.$key);
            }
        }
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
            /*
            $obj_ref = new ReflectionObject($this);
            //$temp = Reflection::getModifierNames(2);
            
            $prop_ref = $obj_ref->getProperty($property);
            //512 protected
            //1024 private
            if($prop_ref->getModifiers() == 1024)
            $prop_ref->setAccessible(true);
            $prop_ref->setValue($this, $value);
            
            $prop_ref->setAccessible(false);
            
            $mod = $prop_ref->getModifiers();
            $temp = Reflection::getModifierNames($mod);
            echo '['.$property.'] -> '.$mod .' -> '.$temp[0].'<br>'; 
             * 
             */
        }

        return $this;
    }

}