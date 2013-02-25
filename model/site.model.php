<?php

require_once 'model/default.model.php';

class siteModel extends defaultModel {

	
    function __construct() {
        parent::__construct('site');
    }

    function get_all_sites() {
        return $this->get_all(false);
    }

    function get_all_templates() {
        return $this->get_all(true);
    }

    function get_all($is_template = false) {//para não partir chamadas antigas está com = false
        $values = array();
	  $is_template_value = 0;
	  if($is_template) $is_template_value=1;
        try {
            $sql = '
                SELECT
                    `site`.`id`,
                    `site`.`name`,
                    `community`.`name` as community,
                    `site`.`domain` as url,
                    `aux_languages`.`short` as language,
                    `site`.`teaser` as `teaser mode`,
                    `aux_countries`.`printable_name` as country_name,
                    `aux_countries`.`name` as name,
                    `aux_countries`.`printable_name` as printable_name
                FROM
                    `site`,
                    `community` ,
                    `aux_languages`,
                    `aux_countries`
                WHERE 1 = 1
                AND `community`.id = `site`.fk_community_id
                AND `aux_languages`.`id` =  `site`.`fk_default_language_id`
                AND `aux_countries`.id = `community`.`fk_aux_countries_id`
		    AND `site`.is_active = 1
		    AND `community`.is_active = 1
                AND `site`.is_template = ' . $is_template_value . ';
                ';
            $this->connect();
            $result = $this->mysql_query($sql);
            while ($value = mysql_fetch_assoc($result)) {
                $values[] = $value;
            }
            $this->disconnect();
        } catch (Exception $e) {
            Logger::exception($this, $e);
            $this->disconnect();
            throw $e;
        }
        return $values;
    }

    /**
     *
     * @param type $site_id
     * @throws Exception
     */
    function switch_site_mode_by_id($site_id) {
        $result = NULL;
        try {
            //validate site
            $site = $this->getById($site_id);
            if ($site) {//site is valid
                if ($site['teaser']) { //set_site_mode
                    $result = $this->set_site_mode($site_id);
                } else {//set_teaser_mode
                    $result = $this->set_teaser_mode($site_id);
                }
            } else {
                throw new Exception('No such site', 0);
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $result;
    }

    function update_by_id($id, $arrayValues) {
        try {
            $this->connect();
            $this->begin_transaction();
            $db_site = $this->getById($id);
            //Comunity was updateed lets handle site
            if ($db_site) {
                $ret_val = parent::update_by_id($id, $arrayValues);

                if (!$ret_val['boolean']) {
                    throw new ErrorException($ret_val['message'], 0);
                }
                if ($db_site['teaser'] != $arrayValues['teaser']) {
                    $ret_val = $this->switch_site_mode_by_id($db_site['id']);
                }
            }


            $this->commit_transaction();
        } catch (Exception $e) {
            $this->rollback_transaction();
            throw $e;
        }
        return $ret_val;
    }
    
	function update_by_idV2($id, $arrayValues) {
        try {
            $this->connect();
            $this->begin_transaction();
            $db_site = $this->getById($id);
            //Comunity was updateed lets handle site
            if ($db_site) {
                $ret_val = parent::update_by_id($id, $arrayValues);

                if (!$ret_val['boolean']) {
                    throw new ErrorException($ret_val['message'], 0);
                }
            }


            $this->commit_transaction();
        } catch (Exception $e) {
            $this->rollback_transaction();
            throw $e;
        }
        return $ret_val;
    }
    /**
     *
     * @param int $site_id
     * @return boolean
     */
    private function set_site_mode($site_id) {
        $result = NULL;
        require_once 'model/page.model.php';
        $pages_model = new pageModel();
        $pages = $pages_model->get_by_site_id($site_id);

        foreach ($pages as $page) {
            //Activate pages
            switch ($page['original_name']) {
                case 'site_entrance':
                case 'Registo':
                case 'Recuperar Pass':
                case 'Questionario':
                case 'Questionario mostra':
                case 'Perfil':
                case 'Informação':
                case 'Campanhas':
                    $arrayValues = array('is_active' => true);
                    $result = $pages_model->update_by_id($page['id'], $arrayValues);
                    break;
            }

            //Activate set menu order
            switch ($page['original_name']) {
                case 'Embaixadores':
                case 'Perfil':
                    $arrayValues = array('menu_order' => 1);
                    $result = $pages_model->update_by_id($page['id'], $arrayValues);
                    break;
                case 'Empresas':
                case 'Campanhas':
                    $arrayValues = array('menu_order' => 2);
                    $result = $pages_model->update_by_id($page['id'], $arrayValues);
                    break;
                case 'Questionario':
                case 'Contacta-nos':
                    $arrayValues = array('menu_order' => 3);
                    $result = $pages_model->update_by_id($page['id'], $arrayValues);
                    break;
                case 'Wom no Mundo':
                case 'Informação':
                    $arrayValues = array('menu_order' => 4);
                    $result = $pages_model->update_by_id($page['id'], $arrayValues);
                    break;
            }
        }

        if ($result['boolean']) {
            $arrayValues = array('teaser' => false);
            $result = $this->update_by_id($site_id, $arrayValues);
        }
        return $result;
    }

    private function set_teaser_mode($site_id) {
        $result = NULL;
        require_once 'model/page.model.php';
        $pages_model = new pageModel();
        $pages = $pages_model->get_by_site_id($site_id);

        foreach ($pages as $page) {
            //Deactivate pages
            switch ($page['original_name']) {
                case 'site_entrance':
                case 'Registo':
                case 'Recuperar Pass':
                case 'Questionario':
                case 'Questionario mostra':
                case 'Perfil':
                case 'Informação':
                case 'Campanhas':
                    $arrayValues = array('is_active' => false);
                    $result = $pages_model->update_by_id($page['id'], $arrayValues);
                    break;
            }

            //Activate set menu order
            switch ($page['original_name']) {
                case 'Embaixadores':
                case 'Perfil':
                    $arrayValues = array('menu_order' => 1);
                    $result = $pages_model->update_by_id($page['id'], $arrayValues);
                    break;
                case 'Empresas':
                case 'Campanhas':
                    $arrayValues = array('menu_order' => 2);
                    $result = $pages_model->update_by_id($page['id'], $arrayValues);
                    break;
                case 'Questionario':
                case 'Contacta-nos':
                    $arrayValues = array('menu_order' => 3);
                    $result = $pages_model->update_by_id($page['id'], $arrayValues);
                    break;
                case 'Wom no Mundo':
                case 'Informação':
                    $arrayValues = array('menu_order' => 4);
                    $result = $pages_model->update_by_id($page['id'], $arrayValues);
                    break;
            }
        }

        if ($result['boolean']) {
            $arrayValues = array('teaser' => true);
            $result = parent::update_by_id($site_id, $arrayValues);
        }
        return $result;
    }

    /**
     *
     * @param type $arrayValues
     * @param type $site_pages
     * @return type
     * @throws Exception
     */
    function persist_with_pages($arrayValues, $site_pages) {
        try {
            $results = array();
            $insertSiteResult = parent::persist($arrayValues); //Criação do site
            $results['boolean'] = $insertSiteResult['boolean'];
            $results['messages'][] = $insertSiteResult['message'];
            //INSERTED SITE
            if ($insertSiteResult['boolean']) {
                //require_once 'pageType.model.php';
                //$pageTypeModel = new pageTypeModel();
                require_once 'model/page.model.php';
                $pModel = new pageModel();

                foreach ($site_pages as $current_page) {
                    //transform page template into page
                    $current_page['fk_site_id'] = $insertSiteResult['id'];
                    $current_page['original_name'] = $current_page['name'];
                    $current_page['printable_name'] = $current_page['name'];
                    unset($current_page['name']);

                    $pageResult = $pModel->persist($current_page); // INSERT PAGE
                    if (!$pageResult['boolean']) {
                        throw new Exception($pageResult['message']);
                    }
                    $bd_page = $pModel->getById($pageResult['id']);

                    //$results['messages'][] = $pageResult['message'];
                    //Create contents
                    require_once 'model/page_type_component.model.php';
                    $model = new pageTypeComponentModel();
                    require_once 'model/content.model.php';
                    $contentModel = new contentModel($this->Country);

                    $components = $model->getByPageType($bd_page['fk_page_type_id']);

                    foreach ($components as $component) {

                        $arrValues['page_id'] = $bd_page['id'];
                        $arrValues['area_id'] = $component['name'];
                        //$arrValues['html'] = 'No content set';
                        $arrValues['type'] = $component['type'];

                        $contentResult = $contentModel->persist($arrValues);
                        $results['boolean'] = $results['boolean'] && $contentResult['boolean'];
                        $results['messages'][] = $contentResult['message'];

                        $default_value = 'no default value';
                        //get default value
                        if (!empty($component['default_value'])) {
                            $default_value = $component['default_value'];
                        }

                        switch ($component['type']) {
                            case 'div_slider':
                                require_once 'model/default.model.php';
                                $model = new defaultModel('content_div_slider');

                                $htmlResult = $model->persist(array('id' => $contentResult['id'], 'name' => $default_value));
                                $results['boolean'] = $results['boolean'] && $htmlResult['boolean'];
                                $results['messages'][] = $htmlResult['message'];

                                break;
                            case 'row':
                                require_once 'model/default.model.php';
                                $model = new defaultModel('content_row');
                                $htmlResult = $model->persist(array('id' => $contentResult['id'], 'name' => $default_value));
                                $results['boolean'] = $results['boolean'] && $htmlResult['boolean'];
                                $results['messages'][] = $htmlResult['message'];
                                break;
                            case 'acordeon':
                                break;
                            default:

                                require_once 'model/default.model.php';
                                $ct = 'content_' . $component['type'];
                                $model = new defaultModel($ct);
                                $textResult = $model->persist(array('id' => $contentResult['id'], 'value' => $default_value));
                                $results['boolean'] = $results['boolean'] && $textResult['boolean'];
                                $results['messages'][] = $textResult['message'];
                                break;
                        }
                    }
                }
            } else {
                throw new Exception($insertSiteResult['message']);
            }
        } catch (Exception $e) {
            Logger::exception($this, $e);
            throw $e;
        }
        return $results;
    }

    function get_for_renderization_by_id($site_id) {

        $site = parent::getById($site_id);
	  
        require_once 'model/community.model.php';
        $community_model = new communityModel($this->Country);
        $community = $community_model->getById($site['fk_community_id']);

        require_once 'model/business.model.php';
        $bussiness_model = new businessModel();
        $bussiness = $bussiness_model->getById($community['fk_business_id']);
        $site['type'] = $bussiness['name'];
        return $site;
    }

    
    function persist_to($site_to){
        if($site_to instanceof siteTO){
            $arrayValues = $site_to->get_array();
            parent::persist($arrayValues);
        }
    }
    

	public function get_complete_by_id($a_template_site_id) {

		//load the reference template site
		$site_record = $this->getById($a_template_site_id);

		require_once 'model/page.model.php';
		//require_once 'to/page.to.php';
		//require_once 'to/page_type.to.php';

		
		$page_model = new pageModel();
		$pages_record = $page_model->get_by_site_idV2($a_template_site_id);
		
		
		//save
		unset($site_record['id']);
		$site_record['name'] = "copy of " . $site_record['name'];
		
		if(DEBUG){
			$site_record['fk_community_id'] = 5;
			$site_record['fk_default_language_id'] = 10;
			$site_record['teaser'] = 1;
		}
		
		$insert_ret_call = $this->persist($site_record);
		$new_site_id = $insert_ret_call['id'];
		
		foreach($pages_record as $page_record){
			$page_id = $page_record["id"];
			unset($page_record["id"]);
			$page_record["fk_site_id"] = $new_site_id;
			
			$insert_ret_call = $page_model->persist($page_record);
			$new_page_id = $insert_ret_call['id'];
			
			require_once 'model/content.model.php';
			$content_model = new contentModel($this->Country);
			$content = $content_model->get_content_by_page_idV2($page_id, 1);

			$content= $content;
			
			
			
			foreach($content as $content_entry){
				//unset($content_record["id"]);
				//$content_id = $content_record['id'];
				$content_record = $content_entry['content_record'];
				
				unset($content_record['id']);
				$content_record['page_id'] = $new_page_id;
				$persist_call_res = $content_model->persist($content_record);
				$new_content_id = $persist_call_res['id'];

				$content_type = $content_record['type'];
				
				  switch ($content_type) {
						case 'acordeon':
							//$ret_val["specific_record"] = $specific_record;
							$specific_table_name =  "content_$content_type";
							require_once 'model/default.model.php';
							$specific_content_model = new defaultModel($specific_table_name);
 
							
							$specific_record = $content_entry["specific_record"];
							$key = "{$specific_table_name}_record";
							$content_acordeon_record = $specific_record[$key];
							
							$content_acordeon_record['id'] = $new_content_id;
							$persist_call_res = $specific_content_model->persist($content_acordeon_record);
							$new_acordeon_content_id = $persist_call_res['id'];
							
							$content_graph =  $specific_record["content_graph"];
							$sections = $content_graph['sections'];
							foreach($sections as $section){
								$section_record = $section["section_record"];
								$section_record["fk_acordeon_id"] = $new_content_id;								
								$section_content_graph = $section["content_graph"];
								
								$text_content  = $section_content_graph["text"];
								$text_content_record  = $text_content["content_record"];
								unset($text_content_record["id"]);
								$persist_call_res2 = $content_model->persist($text_content_record);
								$new_text_content_id = $persist_call_res2['id'];
								$section_record["text"] = $new_text_content_id;
								
								$content_type2 = $text_content_record["type"];
								$specific_table_name2 = "content_$content_type2"; 
								$text_specific_record = $text_content["specific_record"][$specific_table_name2];
								$text_specific_record["id"] = $new_text_content_id;
								
								require_once 'model/default.model.php';
								$specific_content_model2 = new defaultModel($specific_table_name2);
								
								$specific_content_model2->persist($text_specific_record);
								
								require_once 'model/default.model.php';
								$section_model = new defaultModel("content_acordeon_section");
								unset($section_record['id']);
								$section_model->persist($section_record);
								 
							}
							
							
							
						    break;
						case 'row':
							//$ret_val["specific_record"] = $specific_record;


						    break;
						case 'div_slider':		 
							//$ret_val["specific_record"] = $specific_record;

						    break;
						default:
							$specific_table_name = "content_$content_type"; 
							require_once 'model/default.model.php';
							$specific_content_model = new defaultModel($specific_table_name);

							$specific_record = $content_entry["specific_record"][$specific_table_name];
							
							$specific_record['id'] = $new_content_id;
							$specific_content_model->persist($specific_record);
							
						
							

							break;
				  }

			}
						
		}
			
		return $new_site_id;
		
		
		
	}

    
    public function duplicate($a_site_id_to_duplicate){
	    $duplicated_site_id = null;
	    try{
		$duplicated_site_id = $this->get_complete_by_id($a_site_id_to_duplicate);
	    }
	    catch(Exception $e){
		    var_dump($e);
		    
	    }
	    
	    return $duplicated_site_id;
	    
    }
    

    
}
