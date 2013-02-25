<?php

require_once'default.model.php';
require_once 'util/TextUtil.php';
require_once 'util/Logger.php';

class contentModel extends defaultModel {

	
    function __construct() {
        parent::__construct('content');
    }

    function get_content_by_id_if_the_id_is_set($a_content_id, $a_country=null){
	   DBCHelper2::require_that()->the_param($a_country)->is_not_null();
	    $ret_val = "";
	    
	    if(isset($a_content_id) && $a_content_id!=0){
		    $ret_val = $this->get_content_by_id($a_content_id, $a_country);
	    }
	    else{
		   $ret_val = ""; 
	    }
	    return  $ret_val;
		    
    }
    
    function get_content_by_id($content_id, $a_country=null) {
	   Logger::debug($this, 'get_content_by_id(content_id[' . $content_id . '])');
	   DBCHelper2::require_that()->the_param($a_country)->is_not_null();

        $result = NULL;
        $sql = 'SELECT * FROM content WHERE id = ' . $content_id . ' ;';
	    parent::connect();
        $result_set = $this->mysql_query($sql);
        $content_record = mysql_fetch_assoc($result_set);

        switch ($content_record['type']) {
            case 'acordeon':
			$content_record_id = $content_record['id'];
                $acordeon_section_query = "SELECT * FROM content_acordeon_section WHERE fk_acordeon_id={$content_record_id} order by display_order, id";
			
		    parent::connect();
                $acordeon_section_resultset = $this->mysql_query($acordeon_section_query);

                if (!$acordeon_section_resultset) {
                    Logger::debug($this, $acordeon_section_resultset . ' GOT no result' . mysql_error());
                }
                if (mysql_num_rows($acordeon_section_resultset) == 0) {
                    Logger::debug($this, $acordeon_content_query . "No sections found");
                } else {
                    while ($acordeon_section_record = mysql_fetch_assoc($acordeon_section_resultset)) {
                        $result[$acordeon_section_record['id']]['text'] = $this->get_content_by_id($acordeon_section_record['text'], $a_country);
				$result[$acordeon_section_record['id']]['html'] = $this->get_content_by_id($acordeon_section_record['html'], $a_country);

				$result[$acordeon_section_record['id']]["zContentDescriptors"]['text']['id'] = $acordeon_section_record['text'];
				$result[$acordeon_section_record['id']]["zContentDescriptors"]['html']['id'] = $acordeon_section_record['html'];
                    }
                }
                break;
            case 'row':
                $row_content_query = "SELECT * FROM content_row_cols WHERE fk_row_cols_id=" . $content_record['id'] .";";
			
		    parent::connect();
                $row_content_resultset = $this->mysql_query($row_content_query);

                if (!$row_content_resultset) {
                    Logger::debug($this, $row_content_query . ' GOT no result' . mysql_error());
                }
                if (mysql_num_rows($row_content_resultset) == 0) {
                    Logger::debug($this, $row_content_query . "No sections found");
                } else {
                    while ($row_slide_record = mysql_fetch_assoc($row_content_resultset)) {
				$id =$row_slide_record['id'];
				$col = array();
                        $col['img'] = $this->get_content_by_id($row_slide_record['fk_content_img_id'], $a_country);
                        $col['text'] = $this->get_content_by_id($row_slide_record['fk_content_text_id'], $a_country);
                        $col['html'] = $this->get_content_by_id($row_slide_record['fk_content_html_id'], $a_country);
				$col['link'] = $this->get_content_by_id($row_slide_record['fk_content_link_id'], $a_country);

				$col["zContentDescriptors"]['img']['id'] = $row_slide_record['fk_content_img_id'];
				$col["zContentDescriptors"]['text']['id'] = $row_slide_record['fk_content_text_id'];
				$col["zContentDescriptors"]['html']['id'] = $row_slide_record['fk_content_html_id'];
				$col["zContentDescriptors"]['link']['id'] = $row_slide_record['fk_content_link_id'];
				
				$result[] = $col;
                    }
                }
                break;
            case 'div_slider':		 
                $div_slider_content_query = "SELECT * FROM content_div_slider_slide WHERE fk_div_slider_id=" . $content_record['id'];
			
		    parent::connect();
                $div_slider_content_resultset = $this->mysql_query($div_slider_content_query);

                if (!$div_slider_content_resultset) {
                    Logger::debug($this, $div_slider_content_query . ' GOT no result' . mysql_error());
                }
                if (mysql_num_rows($div_slider_content_resultset) == 0) {
                    Logger::debug($this, $div_slider_content_query . "No sections found");
                } else {
                    while ($div_slider_slide_record = mysql_fetch_assoc($div_slider_content_resultset)) {
                        //$result[$div_slider_slide_record['id']]['img'] = $this->get_content_by_id($div_slider_slide_record['img']);
				$title_id = $div_slider_slide_record['title'];
                        $result[$div_slider_slide_record['id']]['title'] = $this->get_content_by_id_if_the_id_is_set($title_id, $a_country);
				$sub_title_id = $div_slider_slide_record['sub_title'];
                        $result[$div_slider_slide_record['id']]['sub_title'] = $this->get_content_by_id_if_the_id_is_set($sub_title_id, $a_country);
				$html_id = $div_slider_slide_record['html'];
                        $result[$div_slider_slide_record['id']]['html'] = $this->get_content_by_id_if_the_id_is_set($html_id, $a_country);
				$img_id = $div_slider_slide_record['img'];
				$result[$div_slider_slide_record['id']]['img'] = $this->get_content_by_id_if_the_id_is_set($img_id, $a_country);
				$link_id = $div_slider_slide_record['link'];
				$result[$div_slider_slide_record['id']]['link'] = $this->get_content_by_id_if_the_id_is_set($link_id, $a_country);
								

				$result[$div_slider_slide_record['id']]["zContentDescriptors"]['title']['id'] = $div_slider_slide_record['title'];
				$result[$div_slider_slide_record['id']]["zContentDescriptors"]['sub_title']['id'] = $div_slider_slide_record['sub_title'];
				$result[$div_slider_slide_record['id']]["zContentDescriptors"]['html']['id'] = $div_slider_slide_record['html'];
				$result[$div_slider_slide_record['id']]["zContentDescriptors"]['img']['id'] = $div_slider_slide_record['img'];
				$result[$div_slider_slide_record['id']]["zContentDescriptors"]['link']['id'] = $div_slider_slide_record['link'];
                    }
                }
                break;
            default:			
                $sql = 'SELECT * FROM content_' . $content_record['type'] . ' WHERE id=' . $content_record['id'];
			
		    parent::connect();
                $record_set = $this->mysql_query($sql);
                if (!$record_set) {
                    Logger::debug($this, $sql . ' GOT no result' . mysql_error());
                }

                if (mysql_num_rows($record_set) == 0) {
                    Logger::debug($this, $sql . "No rows found");
                    //Nothing todo simple content
                } else {
                    $temp_result = mysql_fetch_array($record_set); //TODO tirar sóo value na query
                    $result = $temp_result['value'];
                }
		    
		    if($content_record['type']=="html"){
			    $result_with_replaced_vars = $this->html_replace_vars($result, $a_country);
			    $result = $result_with_replaced_vars;
		    }
		    if($content_record['type']=="link"){
			    $result_with_replaced_vars = $this->html_replace_vars($result, $a_country);
			    $result = $result_with_replaced_vars;
		    }
		    if($content_record['type']=="text"){
			    $result_with_replaced_vars = $this->html_replace_vars($result, $a_country);
			    $result = $result_with_replaced_vars;
		    }
        }
        return $result;
    }
    
    
    private function  html_replace_vars($a_content, $a_country){
		DBCHelper2::require_that()->the_param($a_country)->is_not_null();
		$ret_val = $a_content;

		if(strpos($a_content, '{{$BASEPATH}}')!==FALSE){
			$ret_val = str_replace('{{$BASEPATH}}', BASEPATH, $a_content);
		}
		
		if(strpos($ret_val, '{{$COUNTRY}}')!==FALSE){

			$country_name = $a_country['name'];
			DBCHelper2::assert_that()->the_variable($country_name)->is_a_string();
			$ret_val = str_replace('{{$COUNTRY}}', $country_name , $ret_val);
		}
					
		if(strpos($ret_val, '{{$COMMUNITY_MEMBERS_CONTACT_EMAIL}}')!==FALSE){

			$members_contact_email =  $this->get_community_members_contact_email($a_country); 
			DBCHelper2::assert_that()->the_variable($members_contact_email)->is_a_string();
			$ret_val = str_replace('{{$COMMUNITY_MEMBERS_CONTACT_EMAIL}}', $members_contact_email , $ret_val);
		}
		
		if(strpos($ret_val, '{{$COMMUNITY_COMPANIES_CONTACT_EMAIL}}')!==FALSE){

			$companies_contact_email =  $this->get_community_companies_contact_email($a_country); 
			DBCHelper2::assert_that()->the_variable($companies_contact_email)->is_a_string();
			$ret_val = str_replace('{{$COMMUNITY_COMPANIES_CONTACT_EMAIL}}', $companies_contact_email , $ret_val);
		}
		
		if(strpos($ret_val, 'Ambassadors.com')!==FALSE){

			$community_name =  $this->get_community_name($a_country); 
			DBCHelper2::assert_that()->the_variable($community_name)->is_a_string();
			$ret_val = str_replace('Ambassadors.com', $community_name , $ret_val);
		}

		if(strpos($ret_val, 'AMBASSADORS.COM')!==FALSE){

			$community_name =  $this->get_community_name($a_country); 
			$community_name = strtoupper($community_name);
			DBCHelper2::assert_that()->the_variable($community_name)->is_a_string();
			$ret_val = str_replace('AMBASSADORS.COM', $community_name , $ret_val);
		}

		if(strpos($ret_val, 'Embaixadores.com')!==FALSE){

			$community_name =  $this->get_community_name($a_country); 
			DBCHelper2::assert_that()->the_variable($community_name)->is_a_string();
			$ret_val = str_replace('Embaixadores.com', $community_name , $ret_val);
		}

		if(strpos($ret_val, 'EMBAIXADORES.COM')!==FALSE){

			$community_name =  $this->get_community_name($a_country); 
			$community_name = strtoupper($community_name);
			DBCHelper2::assert_that()->the_variable($community_name)->is_a_string();
			$ret_val = str_replace('EMBAIXADORES.COM', $community_name , $ret_val);
		}

		return $ret_val;
	}
	
	private function get_community_members_contact_email($a_country){
		switch($a_country['id']){
			case "PT":
				return "membros@embaixadores.com";
				break;
			case "GR": 
				return "membersgreece@wom-ambassadors.com";
				break;
			case "GB": 
				return "members.uk@wom-ambassadors.com";
				break;
			case "ES": 
				return "miembros.espana@wom-embajadores.com";
				break;
			case "BR": 
				return "membros.brasil@embaixadores.com";
				break;
			default:
				throw new Exception("Not supported country [{$a_country}].");
				break;			
		}
	}
	
	private function get_community_companies_contact_email($a_country){
		switch($a_country['id']){
			case "PT":
				return "empresas@embaixadores.com";
				break;
			case "GR": 
				return "companiesgreece@wom-ambassadors.com";
				break;
			case "GB": 
				return "companies.uk@wom-ambassadors.com";
				break;
			case "ES": 
				return "empresas.espana@wom-embajadores.com";
				break;
			case "BR": 
				return "empresas.brasil@embaixadores.com";
				break;
			default:
				throw new Exception("Not supported country [{$a_country}].");
				break;			
		}
		
		return ;
	}

	private function get_community_name($a_country){
		$ret_val = "Embaixadores.com";
		$country_code = $a_country['id'];
		switch ($country_code) {
			case 'PT':
				$ret_val = "Embaixadores.com";
				break;

			default:
				$ret_val = "Ambassadors.com";
				break;
		}
		return $ret_val;
	}
	
    function get_acordeon_content_by_id($a_acordeon_content_id){
	    
	    $ret_val = null;
	    
			$query = "SELECT * FROM content_acordeon WHERE id=$a_acordeon_content_id;";
			
		    parent::connect();
                $mysql_res = $this->mysql_query($query);

                $acordeon_record = mysql_fetch_assoc($mysql_res);
		    

		    $ret_val["content_acordeon_record"] = $acordeon_record;
		    
	    
                $query = "SELECT * FROM content_acordeon_section WHERE fk_acordeon_id=$a_acordeon_content_id;";
			
                $mysql_res = $this->mysql_query($query);

			while ($section_record = $this->mysql_fetch_assoc($mysql_res)) {
				$section_entry=array("section_record"=>$section_record, "content_graph"=>array());
				$content_graph = array();

				$section_id = $section_record['id'];

				$text_content_id = $section_record['text'];
				 $html_content_id = $section_record['html'];
				 
				 $text_content_record = $this->get_content_by_idV2($text_content_id);;
				 $html_content_record = $this->get_content_by_idV2($html_content_id);
				 
				$content_graph['text'] = $text_content_record;
				$content_graph['html'] = $html_content_record;

				$section_entry["content_graph"] = $content_graph;
				
				$ret_val['content_graph']["sections"][] = $section_entry;
                    }
		  
			  return $ret_val;
    }
    
       function get_row_content_by_id($a_row_content_id){
		  $ret_val = null;
		  
                $query = "SELECT * FROM content_row WHERE id=$a_row_content_id;";
		    parent::connect();
                $mysql_res = $this->mysql_query($query);

		    $row_record = $this->mysql_fetch_assoc($mysql_res);

		    $ret_val["content_row_record"] = $row_record;

		    
		    $query = "SELECT * FROM content_row_cols WHERE fk_row_cols_id=$a_row_content_id;";
			
                $mysql_res = $this->mysql_query($query);

                    while ($col_record = $this->mysql_fetch_assoc($mysql_res)) {
				//$id =$row_slide_record['id'];
				$col_entry=array("col_record"=>$col_record, "content_graph"=>array());
				$content_graph = array();

				$col_id = $col_record['id'];
				
				$img_content_id = $col_record['fk_content_img_id'];
				$text_content_id = $col_record['fk_content_text_id'];
				$html_content_id = $col_record['fk_content_html_id'];

				$img_content_record = $this->get_content_by_idV2($img_content_id);
				$text_content_record = $this->get_content_by_idV2($text_content_id);
				$html_content_record = $this->get_content_by_idV2($html_content_id);

				$content_graph['fk_content_img_id'] = $img_content_record;
				$content_graph['fk_content_text_id'] = $text_content_record;
				$content_graph['fk_content_html_id'] = $html_content_record;

				$col_entry["content_graph"] = $content_graph;
				
				$ret_val['content_graph']["cols"][] = $col_entry;
                    }
		  
			  return $ret_val;
	 }

       function get_slider_content_by_id($a_slider_content_id){
			$ret_val = null;
		  
                $query = "SELECT * FROM content_div_slider WHERE id=$a_slider_content_id";

		    parent::connect();
                $mysql_res = $this->mysql_query($query);		 
		    
		    $slider_record = $this->mysql_fetch_assoc($mysql_res);

		    $ret_val["content_div_slider_record"] = $slider_record;
		    

		    $query = "SELECT * FROM content_div_slider_slide WHERE fk_div_slider_id=$a_slider_content_id";
			
                $mysql_res = $this->mysql_query($query);		 

                    while ($slide_record = $this->mysql_fetch_assoc($mysql_res)) {
				$slide_entry=array("slide_record"=>$slide_record, "content_graph"=>array());
				$content_graph = array();

				$slide_id = $slide_record['id'];
				
				  
				  $title_content_id = $slide_record['title'];
				  $sub_title_content_id = $slide_record['sub_title'];
				  $html_content_id = $slide_record['html'];

				 $title_content_record = $this->get_content_by_idV2($title_content_id);
				 $sub_title_content_record = $this->get_content_by_idV2($sub_title_content_id);
				 $html_content_record = $this->get_content_by_idV2($html_content_id);

				$content_graph['title'] = $title_content_record;
				$content_graph['sub_title'] = $sub_title_content_record;
				$content_graph['html'] = $html_content_record;

				$slide_entry["content_graph"] = $content_graph;
				
				$ret_val['content_graph']["slides"][] = $slide_entry;
				 
                    }
                
		    return $ret_val;
		    
	}
    
    function get_content_by_idV2($content_id) {
        $ret_val = NULL;
        $sql = 'SELECT * FROM content WHERE id = ' . $content_id . ' ;';
	    parent::connect();
        $result_set = $this->mysql_query($sql);
        $content_record = $this->mysql_fetch_assoc($result_set);

	  $ret_val["content_record"] = $content_record;
	  
        switch ($content_record['type']) {
            case 'acordeon':
			$specific_record = $this->get_acordeon_content_by_id($content_id);
			$ret_val["specific_record"] = $specific_record;
			
                break;
            case 'row':
			$specific_record = $this->get_row_content_by_id($content_id);
			$ret_val["specific_record"] = $specific_record;
			
			
                break;
            case 'div_slider':		 
			$specific_record = $this->get_slider_content_by_id($content_id);
			$ret_val["specific_record"] = $specific_record;
			
                break;
            default:			
			$content_type = $content_record['type'];
			$specific_table_name = "content_$content_type"; 
                $query = "SELECT * FROM $specific_table_name WHERE id=$content_id;";
			
		    parent::connect();
                $query_res = $this->mysql_query($query);
                    $content_record = mysql_fetch_assoc($query_res); //TODO tirar sóo value na query
			  $ret_val["specific_record"][$specific_table_name] = $content_record;
                    $ret_val["specific_record"]["content_graph"] = null;
        }
        return $ret_val;
    }

    function get_content_by_page_idV2($a_page_id){
	  $ret_val = NULL;
        $query = "SELECT * FROM content WHERE page_id = $a_page_id ;";
	    parent::connect();
        $query_res = $this->mysql_query($query);
	  $contents_records = array();
        while($content_record = $this->mysql_fetch_assoc($query_res)){
		  $content_id = $content_record['id'];
		  /*
		  $ret_val[$content_id]['content_record']=$content_record;
		  $content_graph = $this->get_content_by_idV2($content_id);
		  $ret_val[$content_id]['content_graph'] = $content_graph;
		  */
		  $content_graph = $this->get_content_by_idV2($content_id);
		  $ret_val[]=$content_graph;
	  };
	  
	  return  $ret_val;
	  
    }
    
    public function get_content_by_id_WRAPPER($a_content_record, $a_country=null){
		$ret_val = null;
	    
		$result['content'] = $this->get_content_by_id($a_content_record['id'], $a_country);
		$result["zContentDescriptor"] = $a_content_record;
		
		$content_type = $a_content_record['type'];
		$content_id = $a_content_record['id'];
		
		
	    $sql = "SELECT * FROM content_{$content_type} WHERE id={$content_id}" ;

	    parent::connect();
	    $query_resh = $this->mysql_query($sql);

	    $content_specific_record = mysql_fetch_array($query_resh); 
	    $result["zContentSpecificDescriptor"] = $content_specific_record;
		parent::disconnect();
		
		
		$ret_val = $result;
		
		return $ret_val;
    
    }
    
    function getContent($page, $language_id = 10, $a_country=null) { //$language_id = 10 -> pt_PT
        Logger::debug($this, 'getContent(page[' . $page . '])');

        parent::connect();
        $contents = array();
        try {
            $sql = "SELECT * FROM content WHERE page_id = $page and fk_language_id = $language_id ;";
		
		parent::connect();
            $result = $this->mysql_query($sql);

            while ($content_record = mysql_fetch_assoc($result)) {

                //$contents[$content_record['area_id']] = $this->get_content_by_id($content_record['id'], $a_country);
		    //$contents["zContentDescriptors"][$content_record['area_id']] = $content_record;
		    
		   $content_data = $this->get_content_by_id_WRAPPER($content_record, $a_country);
		   $contents[$content_record['area_id']] = $content_data['content'];
		   $contents["zContentDescriptors"][$content_record['area_id']] = $content_data['zContentDescriptor'];
		    
                // function (get_coontent($content_id)
                //$contents[] = array_merge($content2, $content);
            }
        } catch (Exception $e) {
            Logger::exception($this, $e);
            Logger::debug($this, "Exception getting content" . $e->getMessage());
            parent::disconnect();
            throw $e;
        }
        parent::disconnect();
        Logger::debug($this, 'getContent(page[' . $page . ']) GOT ' . print_r($contents, true));

        //$contents2 = $this->buildlandingpageForm($contents);

	  $contents["zRequest_Parameters"]["page_id"] = $page;
	  $contents["zRequest_Parameters"]["language_id"] = $language_id;
	  $contents["zRequest_Parameters"]["country"] = $a_country;
        return $contents;
    }

    function getContentV2($page, $language_id = 10) { //$language_id = 10 -> pt_PT
        Logger::debug($this, 'getContent(page[' . $page . '])');

        $ret_val = null;

        $contents = $this->getContent($page, $language_id);

        require_once "classes/page_content.to.php";
        $ret_val = new page_contentTO($contents);



        return $ret_val;
    }
    
    function getContentV3($page, $language_id = 10, $a_country=null) { //$language_id = 10 -> pt_PT
        Logger::debug($this, 'getContent(page[' . $page . '])');

        $ret_val = null;

        $contents = $this->getContent($page, $language_id, $a_country);

        require_once "classes/page_content.to.php";
        //$ret_val = new page_contentTO($contents);
	  $ret_val = $contents;



        return $ret_val;
    }

    private function buildlandingpageForm($contents) {
        foreach ($contents as $currContent) {

            switch ($currContent['type']) {

                case 'acordeon':
                    $content['acordeon'][] = $currContent['acordeon'];
                    break;
                case 'div_slider':
                    $model = new defaultModel('content_div_slider');
                    $content['slider'] = $model->getById($currContent['id']);
                    $model = new defaultModel('slides');
                    $slides = $model->getFilteredBy(array('fk_div_slider_id' => $currContent['id']), true);
                    $content['slider']['slides'] = $slides;
                    break;
                case 'row':
                    //GET ROW
                    $model = new defaultModel('content_row');
                    $content['row'] = $model->getById($content['id']);
                    //GET ROW COLS
                    $model = new defaultModel('row_cols');
                    $cols = $model->getFilteredBy(array('fk_row_cols_id' => $currContent['id']), true);
                    $content['cols'] = $cols;

                    break;
                default:
                    $area_id = $currContent['area_id'];
                    $value = $currContent['value'];
                    $content[$area_id] = $value;
                    break;
            }
        }


        return $content;
    }

    function updateTextContent($page, $content) {
	  
        try {
		parent::connect();
            foreach ($content as $key => $value) {
                $result = $this->mysql_query('SELECT id FROM content WHERE page_id = ' . $page . ' AND area_id="' . $key . '"');
                $res = mysql_fetch_assoc($result);
                if (isset($res['id'])) {
                    $query = 'UPDATE content_text SET value = "' . mysql_real_escape_string($value) . '" WHERE id = ' . $res['id'];
                    $result = $this->mysql_query($query);
                }
            }
        } catch (Exception $e) {
            Logger::exception($this, $e);
            Logger::debug($this, "Exception getting content" . $e->getMessage());
            throw $e;
        }
        return $result;
    }

    function updateContent($page, $content) {
        try {
		parent::connect();
            foreach ($content as $key => $value) {
                $query = 'UPDATE content SET html = "' . mysql_real_escape_string($value) . '" WHERE page_id = ' . $page . ' AND area_id="' . $key . '"';
                $result = $this->mysql_query($query);
            }
        } catch (Exception $e) {
            Logger::exception($this, $e);
            Logger::debug($this, "Exception getting content" . $e->getMessage());
            throw $e;
        }
        return $result;
    }

    function insertCol($col) {
        $result = array();

        if ($col instanceof col) {
            Logger::debug($this, 'updateRow(' . $col->toString() . ')');
		
            try {
                $query = '
				INSERT INTO `wom_2`.`component_row_cols` (`id`, `icone_class`, `title`, `text`, `fk_row_cols_id`) 
				VALUES (NULL, \'' . $col->iconeClass . '\', \'' . $col->title . '\', \'' . $col->text . '\', \'' . $col->fk_row_cols_id . '\');';
                Logger::debug($this, 'insertCol [' . $query . ']');
		    parent::connect();
                $sqlResult = $this->mysql_query($query);

                $row->id = mysql_insert_id();

                $result['code'] = 0;
                $result['message'] = 'Successfull Update';
                $result['object'] = $col;
            } catch (Exception $e) {
                Logger::exception($this, $e);
                Logger::debug($this, "Exception getting content" . $e->getMessage());
                $result['code'] = -1;
                $result['message'] = $e->getMessage();
            }
        } else {
            $result['code'] = -1;
            $result['message'] = 'Invalid Object';
        }

        return $result;
    }

    function updateCol($col) {
        $result = array();

        if ($col instanceof col) {
            Logger::debug($this, 'updateRow(' . $col->toString() . ')');
            try {
                $query = 'UPDATE component_row_cols SET icone_class = "' . $col->iconeClass . '", title = "' . htmlentities($col->title) . '", text = "' . htmlentities($col->text) . '" WHERE id = ' . $col->id . ';';
                Logger::debug($this, 'updateQuery [' . $query . ']');
		    parent::connect();
                $sqlResult = $this->mysql_query($query);

                $result['code'] = 0;
                $result['message'] = 'Successfull Update';
                $result['object'] = $col;
            } catch (Exception $e) {
                Logger::exception($this, $e);
                Logger::debug($this, "Exception getting content" . $e->getMessage());
                $result['code'] = -1;
                $result['message'] = $e->getMessage();
            }
        } else {
            $result['code'] = -1;
            $result['message'] = 'Invalid Object';
        }

        return $result;
    }

    function updateSlide($id, $content) {
        Logger::debug('updateSlide(' . $id . ', ' . $content . ')');
        try {
		parent::connect();
            foreach ($content as $key => $value) {
                $query = 'UPDATE component_div_slider SET ' . $key . ' = "' . $value . '" WHERE id = ' . $id . ' ;';
                $result = $this->mysql_query($query);
                Logger::debug($query . ' AFECTED ROWS ' . mysql_affected_rows());
            }
        } catch (Exception $e) {
            Logger::exception($this, $e);
            Logger::debug($this, "Exception getting content" . $e->getMessage());
            throw $e;
        }

        //return $this->getContent($page);
    }

    function getRowCols($page) {
        Logger::debug('CONTEN_MODEL::getRowCols(' . $page . ')');
        $result = '';
        try {
            $sql = 'SELECT * FROM col';
		parent::connect();
            $result = $this->mysql_query($sql);
        } catch (Exception $e) {
            Logger::exception($this, $e);
            Logger::debug($this, "Exception getting content" . $e->getMessage());
            throw $e;
        }
        return $result;
    }

    function getComponentById($id) {
        Logger::debug('getComponentById(' . $id . ')');
        $component = array();
        try {
            $query = 'SELECT * FROM `components` WHERE `id` = ' . $id . ';';

            Logger::debug('GET COMPONENT TYPE BY ID QUERY [' . $query . ']');
		parent::connect();
            $result = $this->mysql_query($query);

            if (mysql_num_rows($result) == 1) {
                $type = mysql_fetch_assoc($result);

                Logger::debug('GOT [' . TextUtil::toString($type) . ']');
                /* Getting root component content */
                $mainContent = $this->getComponentMainContent($type['component_type'], $type['id']);
                if (isset($mainContent)) {
                    $component['content'] = $mainContent;
                }

                /* getting subcomponents */
                $subContents = $this->getComponentContent($type['component_type'], $type['id']);
                if (isset($subContents)) {
                    $component['subContents'] = $subContents;
                }
            }
        } catch (Exception $e) {
            Logger::exception($this, $e);
            Logger::debug($this, "Exception getting content" . $e->getMessage());
            throw $e;
        }

        Logger::debug('getComponentById(' . $id . ') GOT ' . print_r($component, true));
        return $component;
    }

    function getComponentMainContent($componentType, $componentId) {
        $mainContent = array();
        try {
            $query = 'SELECT * FROM `' . $componentType . '` WHERE `fk_' . $componentType . '_id` = ' . $componentId . '';
            Logger::debug($this, 'MAIN CONTENT QUERY[' . $query . ']');
		parent::connect();
            $result = $this->mysql_query($query);

            while ($content = mysql_fetch_assoc($result)) {
                Logger::debug($this, 'GOT [' . implode('|', $content) . ']');
                $mainContent[] = $content;
            }

            Logger::debug($this, 'GOT [' . TextUtil::toString($mainContent) . ']');
        } catch (Exception $e) {
            Logger::exception($this, $e);
            Logger::debug($this, "Exception getting content" . $e->getMessage());
            throw $e;
        }
        return $mainContent;
    }

    function getComponentContent($componentType, $componentId) {
        Logger::debug('getComponentContent(' . $componentType . ', ' . $componentId . ')');
        try {
            $query = 'SELECT * FROM `component_' . $componentType . '` WHERE `fk_' . $componentType . '_id` = ' . $componentId . '';
            Logger::debug('COMPONENT QUERY[' . $query . ']');
		parent::connect();
            $result = $this->mysql_query($query);
            while ($content = mysql_fetch_assoc($result)) {
                $contents[] = $content;
            }
        } catch (Exception $e) {
            Logger::exception($this, $e);
            Logger::debug($this, "Exception getting content" . $e->getMessage());
            throw $e;
        }
        Logger::debug('getComponentContent(' . $componentType . ', ' . $componentId . ') GOT [' . print_r($contents, true) . ']');
        return $contents;
    }

}

