<?php

require_once 'util/DBCHelper.php';
require_once 'repository.FACTORY.php';

class repository__FACTORY__TESTS  {
	
	public function __construct(){
		
	}
	
	public function getting_a_repository_for_the_ztest_entity_is_sucessfull(){
		$repository_factory = new repository__FACTORY();
		
		$ztest_repository = $repository_factory->get_repository_by_business_entity_name("ztest");
		
		//DBCHelper2::assert_that()->the_variable($ztest_repository)->is_an_object_instance_of_the_class("ztest__REPO");
				
	}
	
	public function get_a_ztest_entity(){
		$repository_factory = new repository__FACTORY();
		
		$ztest_repository = $repository_factory->get_repository_by_business_entity_name("ztest");

		$ztest = $ztest_repository->get_by_id(1);
	}
	
	public function get_a_assorted_entity(){
		$repository_factory = new repository__FACTORY();
		
		$ztest_repository = $repository_factory->get_repository_by_business_entity_name("ztest");

		$ztest = $ztest_repository->get_by_id(1);
	}
	
	public function get_acontent_repo(){
		$repository_factory = new repository__FACTORY();
		
		$content_repository = $repository_factory->get_repository_by_business_entity_name("content");

		$text = $content_repository->get_by_id(301); //text
		
		$html = $content_repository->get_by_id(983); //html
		$html_value = $html->get_value();
		
		$img = $content_repository->get_by_id(984); //img
		
		$link = $content_repository->get_by_id(6100007); //link
		
		$row = $content_repository->get_by_id(1000); //row
		$row_col_1 = $row->cols[0];
		
		$slider = $content_repository->get_by_id(1001); //div_slide 
		$slider_content = $slider->content;
		
		$slider_is_active = $slider_content->is_active;
		
		$acordeon = $content_repository->get_by_id(1006); //acordeon
		$acordeon_section_1 = $acordeon->sections[0];
		foreach($acordeon_section_1->referenced_contents as $referenced_content){
			$referenced_content_value = $referenced_content->get_value();
		}
		
		$html_str = $acordeon_section_1->get_referenced_content("html");
		
		$contents =  $content_repository->get_contents_by_page_id_and_language_id(329, 48);
		
		//$content_repository->store($html);
		//$content_repository->store($acordeon);
	}

	
	public static function run(){
		$tests = new repository__FACTORY__TESTS();
		$tests->getting_a_repository_for_the_ztest_entity_is_sucessfull();
		$tests->get_a_ztest_entity();
		$tests->get_a_assorted_entity();
		
		$tests->get_acontent_repo();
	}
	

}

