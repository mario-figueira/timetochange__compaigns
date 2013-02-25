<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
<?php
	include_once REALPATH ."views/content_inline_edit.php";

	require_once "classes/page_content.to.php";
	$page_content = new page_contentTO($content); 
?>

<div class="center_main">
	<div class="tit_topo" <?php content_edit_render_editor_call($page_content,'title'); ?> >
		<p><?php echo $page_content->get_content('title'); ?></p>
	</div>

	<?php
		include_once 'views/components/landing_top.php';
	?>
	<div class="divisoria_slide">
		<div class="divisoria_slide_inner"></div>
	</div>
	<?php
	$current_slider = null;
	if(key_exists('div_slider', $content)){
        $current_slider = $content['div_slider'];
	}
	include_once REALPATH.'views/components/slider.php';
	?>

	<?php
	include_once REALPATH.'views/components/row_of_cols.php';
	?>

	<div class="clear"></div>
</div>
