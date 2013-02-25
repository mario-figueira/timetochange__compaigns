<?php		
		$escolha_img_url = $this->build_img_url("escolha1.jpg");
		
		$row_of_cols = null;
		$row_of_cols = $page_content->get_content('row');	
		//$row_of_colsV2 = $contentV2[1];
		
		require_once "classes/page_content.to.php";
		$col_content = array();
		
		for ($index = 0; $index < count($row_of_cols); $index++) {
			if(is_array($row_of_cols)){
				$col_content_descriptor = $row_of_cols[$index];
				if(is_array($col_content_descriptor)){
					$col_content[$index] = new page_contentTO($col_content_descriptor); 
				}
			}
		}
			/*
			$col1_content = new page_contentTO($col1_content_descriptor); 
			$col1_content_title = $col1_content->get_content('text');
			$col1_content_img = $col1_content->get_content('img');
			$col1_content_img_url = $this->build_img_url_when_name_already_has_img_on_the_path($col1_content_img);
			$col1_content_link = $col1_content->get_content('link');
			$col1_content_text = $col1_content->get_content('html');			
		}
		/*
		
		$col2_content_descriptor = $row_of_cols[1];
		if(is_array($col2_content_descriptor)){
			$col2_content = new page_contentTO($col2_content_descriptor); 
			$col2_content_title = $col2_content->get_content('text');
			$col2_content_img = $col2_content->get_content('img');
			$col2_content_img_url = $this->build_img_url_when_name_already_has_img_on_the_path($col2_content_img);
			$col2_content_link = $col2_content->get_content('link');
			$col2_content_text = $col2_content->get_content('html');
		}
		 * 
		 */

		require_once REALPATH . 'views/components/row_of_cols.php';
?>