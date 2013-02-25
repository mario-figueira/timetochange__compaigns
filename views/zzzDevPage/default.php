<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
<?php

	$render_null_body_action_url = $this->build_action_url('zzzDevPage', 'RenderNullBody');
	$render_phpinfo_action_url = $this->build_action_url('zzzDevPage', 'RenderPHPInfo');
	$dump_sysvars_action_url = $this->build_action_url('zzzDevPage', 'DumpSysvars');

?>

<div class="center_main">
<h3>
	Actions
</h3>
<ul>
	<li>
		<h4> <a href="<?php echo $render_null_body_url; ?>">Render null body</a></h4>
	</li>
	<li>
		<h4> <a href="<?php echo $render_phpinfo_action_url; ?>">Render PHPInfo</a></h4>
	</li>
	<li>
		<h4> <a href="<?php echo $dump_sysvars_action_url; ?>">Dump sysvars</a></h4>
	</li>
</ul>
</div>