<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
<div class="center_main">
<?php 
?>
	<ul>
		<li>
			REALPATH:<?php var_dump(REALPATH); ?>
		</li>
		<li>
			BASEPATH:<?php var_dump(BASEPATH); ?>
		</li>
		<li>

			DBHOST:<?php var_dump(DBHOST); ?>
		</li>
		<li>
			<?php var_dump(DBNAME); ?>
		</li>
		<li>
			<?php var_dump(DBUSERNAME); ?>
		</li>
	</ul>
</div>