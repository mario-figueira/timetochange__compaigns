<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
<?php
	include_once REALPATH ."views/content_inline_edit.php";

	require_once "classes/page_content.to.php";
	$page_content = new page_contentTO($content); 
	

?>
<script type="text/javascript" src="<?php echo $active_site['domain'];?>/js/divSlider.js"></script>
<script type="text/javascript" src="<?php echo $active_site['domain'];?>/js/wom.js"></script>

<div class="center_main">
      <div class="tit_topoGrande">
<?php
	include REALPATH ."/views/components/video_popup.php";
?>						
		
        <div class="comoFunciona1" onclick="javascript:landing_page_video_popup('<?php echo $popup_url; ?>', 888, 500);">
		  <a  href="javascript:void(0);"><?php echo _('Como funciona'); ?> &nbsp;
		  </a>
	  </div>
      </div>
	
<?php
	$current_slider = null;
	if(key_exists('div_slider', $content)){
        $current_slider = $content['div_slider'];
	}
	include_once REALPATH.'views/components/slider.php';
?>
	
      
      <!-- if (not login) do -->
<?php 
	$logged_in = $is_logged_in;
	if (!$logged_in) { 
		
		include "not_logged_in_homepage.php";
		
	} else {
		include "logged_in_homepage.php";
	} 
?>
      <div class="clear"></div>
    </div>
