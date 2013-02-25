<?php

require_once __DIR__ ."/ztest.BE.php";

class ztest__BE__Tests {	
	
	
	public function __construct(){
		$this->fields = array();		
	}
	
	public function creation_from_a_record(){
		
		$record = array("id"=>"1", "name"=>"ola ole");
		
		$ztest__instance = ztest__BE::create_from_record($record);
		
		$id = $ztest__instance->id;
		$name = $ztest__instance->name;

		
	}
	
	public function update_from_an_array(){
		
		$record = array("id"=>"1", "name"=>"ola ole");
		
		$ztest__instance = ztest__BE::create_from_record($record);

		$array = array("name"=>"maria salgada", "inexistent_field"=>"ignored_value", "explicit_declared_field"=>"explicit_declared_field_value");
		
		$ztest__instance->update_field_matches_from_array($array);
		
		$id = $ztest__instance->id;
		$name = $ztest__instance->name;
		try{
			$inexistent_field = $ztest__instance->inexistent_field;
		}catch(Exception $ex){
			
		};
		$explicit_declared_field = $ztest__instance->explicit_declared_field;

		
	}
	
	public function setting_existing_class_field_should_be_ok(){
		
		$record = array("id"=>"1", "name"=>"ola ole");
		
		$ztest__instance = ztest__BE::create_from_record($record);
		
		$ztest__instance->explicit_declared_field = "naopma";
		$ztest__instance->name = "nameexp";
		
		$id = $ztest__instance->id;
		$name = $ztest__instance->name;
		try{
			$inexistent_field = $ztest__instance->inexistent_field;
		}catch(Exception $ex){
			
		};
		
		$explicit_declared_field = $ztest__instance->explicit_declared_field;
		
	}
	
	public static function run(){
		$tests = new ztest__BE__Tests();
		$tests->creation_from_a_record();
		$tests->update_from_an_array();
		$tests->setting_existing_class_field_should_be_ok();
	}
}
