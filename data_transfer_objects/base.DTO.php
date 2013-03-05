<?php


class base__DTO{

	private $fields_locked = false;
	private $fields_values_freezed = false;

	
	public function __get($a_field_name){
		$this_class = get_class($this);
		$class_declared_fields = get_class_vars($this_class);
		$class_field_exists = key_exists($a_field_name, $class_declared_fields);

		if(!$class_field_exists){
			throw new DTOFieldNotExistsException();			
		}
		
		return $this->$a_field_name;
	}
	
	public function __set($a_field_name, $a_field_new_value) {
				
		$this_class = get_class($this);
		$class_declared_fields = get_class_vars($this_class);
		$class_field_exists = key_exists($a_field_name, $class_declared_fields);

		if($class_field_exists){
			if($this->fields_values_freezed){
				throw new DTOFreezedException();			
			}
			else{
				// do nothing, let it set the field value 
			}
		}else if($this->fields_locked){
			throw new DTOLockedException();	
		}
		else{
			// do nothing, let it set the field value 
		}
		
		$this->$a_field_name = $a_field_new_value;
		
	}
	
	public function lock(){
		$this->fields_locked = true;
	}
	
	public function unlock(){
		$this->fields_locked = false;		
	}

	public function freeze(){
		$this->fields_values_freezed = true;				
	}

	public function unfreeze(){
		$this->fields_values_freezed = false;						
	}
	
}

class DTOFreezedException extends Exception{
	
}

class DTOLockedException extends Exception{
	
}

class DTOFieldNotExistsException extends Exception{
	
}
