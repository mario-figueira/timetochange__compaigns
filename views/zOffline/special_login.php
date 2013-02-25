<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
<?php
$submit_action_url = $this->build_action_url("zOffline", "special_login_submit");


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

<?php 
	function t($a_msg_id, $a_default_text){
		$translated_text = _($a_default_text);
		
?>
	<span title="msg_id = [<?php echo $a_msg_id; ?>]"> <?php echo $translated_text; ?> </span>
<?php

	}
?>


<div class="center_main">
	<form method="POST" id="contactForm" action="<?php echo $submit_action_url; ?>" class="specialLogin">
		<div class="specialLoginTitle">
			<div style="text-align: center;float:none;" class="texto4">
				<p><?php echo _('Este site encontra-se temporariamente indisponível para manutenção.');?></p>
				<p><?php echo _('Lamentamos qualquer inconveniente.');?></p>
				<p><?php echo _('Por favor volte mais tarde.');?></p>
			</div>
		</div>
		<table class="specialLoginTable">
			<tr>
				<td>
					<label><?php echo _('Login:');?></label>
				</td>
				<td style="width: 150px;">
					<input style="float:right;" id="login_special" type="text" name="login" />
				</td>
			</tr>
			<tr>
				<td>
					<label><?php echo _('Password:');?></label>
				</td>
				<td style="width: 150px;">
					<input style="float:right;" id="password_special" type="password" name="password" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div style="float:right;margin-top:10px;">
						<div class="bt_tamanho4esq"></div>
						<div class="bt_tamanho4central">
							<input class="specialLoginSubmit" type="submit" value=<?php echo _("Submeter");?> />
						</div>
						<div class="bt_tamanho4dir"></div>
					</div>
				</td>
			</tr>
		</table>

	</form>

		
</div>