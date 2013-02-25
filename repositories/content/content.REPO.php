<?php

require_once __DIR__ ."/../base.REPO.php";
require_once REALPATH ."/business_entities/content/content.BE.php";

class content__REPO extends base__REPO {
		
	public function __construct($a_business_entity_name){
		parent::__construct($a_business_entity_name);
	}
	
	public function get_by_id($a_business_entity_id){
		DBCHelper2::require_that()->the_param($a_business_entity_id)->is_an_integer_string();
		
		$ret_val = null;

		$content_record = $this->get_record_by_id($a_business_entity_id);
		
		require_once REALPATH ."/business_entities/content/content.BE.php";
		
		$content = content__BE::create_from_record($content_record);

		
		$content_type = $content->type;
		$content_id = $content->id;

		$concrete_dao = $this->build_concrete_content_dao($content_type);
		
		
		$concrete_record = $concrete_dao->getById($content_id);
		

		$content = $this->build_content_business_entity_object_instance($concrete_record, $content);
		
		$ret_val = $content;
		
		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_an_object_instance_of_the_class("content__BE");
		return $ret_val;
		
	}
	
	private function build_concrete_content_dao($a_content_type){
		$ret_val = null;
		
		require_once REALPATH ."business_entities/content/content_type.BE.php";
		
		require_once REALPATH ."model/default.model.php";
		
		$concrete_table_sufix = strtolower($a_content_type);
		$concrete_dao = new defaultModel("content_{$concrete_table_sufix}");		

		$ret_val = $concrete_dao;
		
		return $ret_val;
	}
	
	

	
	private function build_content_business_entity_object_instance($a_concrete_record, $a_content){
		$ret_val = null;
		
		$content_type = $a_content->type;
		
		$class_PHP_file_to_include = $this->compute_BE_class_PHP_file_by_content_type($content_type);
		require_once $class_PHP_file_to_include;
		
		$class_name = $this->compute_BE_class_name_by_content_type($content_type);
		
		$content = null;
		
		switch ($content_type) {
			case "row":
				$content = $this->build_row($a_concrete_record, $a_content);
				
				break;

			case "div_slider":
				$content = $this->build_div_slider($a_concrete_record, $a_content);

				break;

			case "acordeon":
				$content = $this->build_acordeon($a_concrete_record, $a_content);

				break;

			default:
				$content = $class_name::create_from_record($a_concrete_record, $a_content);
				break;
		}
		
		
		$ret_val = $content;
		
		return $ret_val;
	} 
	
	private function compute_BE_class_name_by_content_type($a_content_type){
		$ret_val = "";
		
		$class_name = "content_{$a_content_type}__BE";
		
		$ret_val = $class_name;
		
		return $ret_val;				
	}
	
	private function compute_BE_class_PHP_file_by_content_type($a_content_type){
		$ret_val = "";
		
		$class_PHP_file = REALPATH ."business_entities/content/content__{$a_content_type}.BE.php";
		
		$ret_val = $class_PHP_file;
		
		return $ret_val;				
	}
	
	private function build_row($a_concrete_record, $a_content){
		$ret_val = null;
		
		$dao = $this->build_concrete_content_dao("row_cols");
		$content_id = $a_content->id;
		$get_filter = array ("fk_row_cols_id"=>$content_id);
		$cols_array = $dao->getFilteredBy($get_filter, true);

		$cols = array();
		$referenced_contents = array();
		foreach($cols_array as $col_record){
			$col = $this->build_row_col($col_record);

			$cols[] = $col;
		}
		
		$content_type = $a_content->type;
		$class_PHP_file_to_include = $this->compute_BE_class_PHP_file_by_content_type($content_type);
		require_once $class_PHP_file_to_include;
		
		$class_name = $this->compute_BE_class_name_by_content_type($content_type);


		$row = $class_name::create_from_record($a_concrete_record, $a_content, $cols);		
		
		$ret_val = $row;
		
		return $ret_val;
	}
	
	private function build_row_col($a_row_col_record){
		$slide_record = $a_row_col_record;
		
		$fields = array();
		require_once REALPATH ."/business_entities/content/content__row_col.BE.php";
	
		$img_content_id = $a_row_col_record['fk_content_img_id'];
		$img_content = $this->get_by_id($img_content_id);
		$referenced_contents['img'] = $img_content;
		
		$text_content_id = $a_row_col_record['fk_content_text_id'];
		$text_content = $this->get_by_id($text_content_id);
		$referenced_contents['text'] = $text_content;		
		
		$html_content_id = $a_row_col_record['fk_content_html_id'];
		$html_content = $this->get_by_id($html_content_id);
		$referenced_contents['html'] = $html_content;
		
		$link_content_id = $a_row_col_record['fk_content_link_id'];
		$link_content = $this->get_by_id($link_content_id);
		$referenced_contents['link'] = $link_content;

		$col = new content_row_col__BE($slide_record, $referenced_contents);	
		
		$ret_val = $col;
		
		return $ret_val;
	}
	
		
	private function build_div_slider($a_concrete_record, $a_content){
		$ret_val = null;
		
		$dao = $this->build_concrete_content_dao("div_slider_slide");
		$content_id = $a_content->id;
		$get_filter = array ("fk_div_slider_id"=>$content_id);
		$slides_array = $dao->getFilteredBy($get_filter, true);

		$slides = array();
		$referenced_contents = array();
		foreach($slides_array as $slide_record){
			$slide = $this->build_div_slider_slide($slide_record);

			$slides[] = $slide;
		}
		
		$content_type = $a_content->type;
		$class_PHP_file_to_include = $this->compute_BE_class_PHP_file_by_content_type($content_type);
		require_once $class_PHP_file_to_include;
		
		$class_name = $this->compute_BE_class_name_by_content_type($content_type);


		$slider = $class_name::create_from_record($a_concrete_record, $a_content, $slides);		
		
		$ret_val = $slider;
		
		return $ret_val;
	}
	
	private function build_div_slider_slide($a_div_slider_slide_record){
		$slide_record = $a_div_slider_slide_record;
		
		$fields = array();
		require_once REALPATH ."/business_entities/content/content__div_slider_slide.BE.php";
	
		$title_content_id = $slide_record['title'];
		$title_content = $this->get_by_id($title_content_id);
		$referenced_contents['title'] = $title_content;
		
		$sub_title_content_id = $slide_record['sub_title'];
		$sub_title_content = $this->get_by_id($sub_title_content_id);
		$referenced_contents['sub_title'] = $title_content;
		
		$img_content_id = $slide_record['img'];
		$img_content = $this->get_by_id($img_content_id);
		$referenced_contents['img'] = $title_content;
		
		$html_content_id = $slide_record['html'];
		$html_content = $this->get_by_id($html_content_id);
		$referenced_contents['html'] = $title_content;
		
		$link_content_id = $slide_record['link'];
		$link_content = $this->get_by_id($link_content_id);
		$referenced_contents['link'] = $title_content;

		$slide = new content_div_slider_slide__BE($slide_record, $referenced_contents);	
		
		$ret_val = $slide;
		
		return $ret_val;
	}
	
	
	private function build_acordeon(array $a_concrete_record, content__BE $a_content){
		DBCHelper2::require_that()->the_param($a_concrete_record)->is_an_array_with_at_least_one_element();
		DBCHelper2::require_that()->the_param($a_content)->is_an_object_instance_of_the_class("content__BE");
		
		$ret_val = null;
		
		$dao = $this->build_concrete_content_dao("acordeon_section");
		$content_id = $a_content->id;
		$get_filter = array ("fk_acordeon_id"=>$content_id);
		$sections_array = $dao->getFilteredBy($get_filter, true);


		$sections = array();
		$referenced_contents = array();
		foreach($sections_array as $section_record){
			$section = $this->build_acordeon_section($section_record);

			$sections[] = $section;
		}
		
		$content_type = $a_content->type;
		$class_PHP_file_to_include = $this->compute_BE_class_PHP_file_by_content_type($content_type);
		require_once $class_PHP_file_to_include;
		
		$class_name = $this->compute_BE_class_name_by_content_type($content_type);


		$acordeon = $class_name::create_from_record($a_concrete_record, $a_content, $sections);

		
		$ret_val = $acordeon;
		
		return $ret_val;
	}
	
	private function build_acordeon_section(array $a_acordeon_section_record){
		$section_record = $a_acordeon_section_record;
		
		$fields = array();
		require_once REALPATH ."/business_entities/content/content__acordeon_section.BE.php";
	
		$text_content_id = $section_record['text'];
		$text_content = $this->get_by_id($text_content_id);
		$referenced_contents['text'] = $text_content;

		$html_content_id = $section_record['html'];
		$html_content = $this->get_by_id($html_content_id);
		$referenced_contents['html'] = $html_content;
		

		$section = new content_acordeon_section__BE($section_record, $referenced_contents);	
		
		$ret_val = $section;
		
		return $ret_val;
	}
	
		
	public function get_contents_by_page_id_and_language_id($a_page_id, $a_language_id){
		DBCHelper2::require_that()->the_param($a_page_id)->is_an_integer_string();
		DBCHelper2::require_that()->the_param($a_language_id)->is_an_integer_string();
		
		$ret_val = null;

		$contents_records = $this->get_contents_records_by_page_id_and_language_id($a_page_id, $a_language_id);
		
		$contents = $this->get_contents_by_contents_records($contents_records);
				
		$ret_val = $contents;
		
		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_an_array();		
		return $ret_val;
		
	}
	
	public function get_contents_records_by_page_id_and_language_id($a_page_id, $a_language_id){
		DBCHelper2::require_that()->the_param($a_page_id)->is_an_integer_string();
		DBCHelper2::require_that()->the_param($a_language_id)->is_an_integer_string();

		$ret_val = null;

		$get_filter = array("page_id"=>$a_page_id, "fk_language_id"=>$a_language_id);
		
		$contents_records = parent::get_records_by_filter($get_filter);

		$ret_val = $contents_records;
		
		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_an_array();
		return $ret_val;
	}
	
	public function get_contents_by_contents_records(array $a_contents_records){
		DBCHelper2::require_that()->the_param($a_contents_records)->is_an_array();
		$ret_val = array();
		
		//require_once REALPATH ."/business_entities/base.BE.php";
		$contents = array();
		foreach($a_contents_records as $content_record){
			$content_id = $content_record['id'];
			$content = $this->get_by_id($content_id);
			$contents[] = $content;
		}
		
		$ret_val = $contents;
		
		DBCHelper2::ensure_that()->the_return_value($ret_val)->is_an_array();
		return $ret_val;
	}
	
	

	public function store($a_content){
		
		
		$content = $a_content->content;

		$content->area_id = $content->area_id ."besuga";
		
		parent::_store($content);
				
		$this->store_content_business_entity_object_instance($a_content);
		
		
		
				
	}
	
	private function store_content_business_entity_object_instance($a_content_business_entity){
				
		//$class_name = $this->compute_BE_class_name_by_content_type($content_type);
		
		$content_type = $a_content_business_entity->content_type;

				
		switch ($content_type) {
			case "row":
				$this->store_row($a_content_business_entity);
				
				break;

			case "div_slider":
				$this->store_div_slider($a_content_business_entity);

				break;

			case "acordeon":
				$this->store_acordeon($a_content_business_entity);

				break;

			default:
				$concrete_fields_record = $a_content_business_entity->_get_fields_array();

				$dao = $this->build_concrete_content_dao($content_type);

				$concrete_table_record = $dao->getById($a_content_business_entity->id);

				$concrete_table_record_exists = isset($concrete_table_record);

				if($concrete_table_record_exists){
					$dao->update_by_id($a_content_business_entity->id, $concrete_fields_record);
				}else{
					$dao->persist($concrete_fields_record);
				}
				
				break;
		}
		
	}
	
	private function store_row($a_content){
		
	}

	private function store_acordeon($a_content){
		
		$dao = $this->build_concrete_content_dao("acordeon");
		$acordeon_table_record = $dao->getById($a_content->id);
		$acordeon_table_record_exists = isset($acordeon_table_record);
		if($acordeon_table_record_exists){
			$dao->update_by_id($a_content->id, $a_content->_get_fields_array());
		}else{
			$dao->insert($a_content->_get_fields_array());
		}
		
		
		
		$dao = $this->build_concrete_content_dao("acordeon_section");
		$content_id = $a_content->id;
		$get_filter = array ("fk_acordeon_id"=>$content_id);
		$sections_table_records = $dao->getFilteredBy($get_filter, true);

		foreach($sections_table_records as $section_record){
//			
//			if($acordeon_table_record_exists){
//				$dao->update_by_id($a_content->id, $a_content->_get_fields_array());
//			}else{
//				$dao->insert($a_content->_get_fields_array());
//			}

		}
	
		
	}

	private function store_slider($a_content){
		
	}
	



}
