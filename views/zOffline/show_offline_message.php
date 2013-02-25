<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
<?php
$base_url = $active_site['domain'] .'/'. $country['name'] .'/zSystem/';

?>

<style>
	.specialLogin{
		margin-left: auto;
		margin-right: auto;
		position: relative;
		top: 50px;
		width: 500px;
	}
	
	.specialLoginTable{
		margin-left: auto;
		margin-right: auto;
		width: 220px;
	}
	
	.specialLoginTitle{
		margin-bottom: 35px;
	}
	
	.specialLoginSubmit{
		background: none repeat scroll 0 0 transparent;
		border: 0 none;
		color: #FFFFFF;
	}
	
</style>


<div class="center_main">
		<div class="specialLoginTitle">
			<div style="text-align: center;float:none;" class="texto4">
				<p><?php echo _('Este site encontra-se temporariamente indisponível para manutenção.');?></p>
				<p><?php echo _('Lamentamos qualquer inconveniente.');?></p>
				<p><?php echo _('Por favor volte mais tarde.');?></p>
			</div>
		</div>


		
</div>