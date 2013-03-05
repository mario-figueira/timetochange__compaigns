<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 
 * Description of default
 *
 * @author mfigueira
 */
?>

<div style="position:relative;left:100px;">
	<!-- END OF HEADER GENERATOR-->
	<!--<div class="tit_topo">
		ERROR
	</div>-->
      <div class="tit_topo_interior">
		<?php if (isset($messages) && is_array($messages) && sizeof($messages)>1 && $messages[1] == 1) {
			?>
			<p><?php echo _("Tem de fazer Login"); ?></p>
			<?php
		} else {
			?>
			<p><?php echo _("Ups...algo correu mal!"); ?></p>
			<?php
		}
		?>
      </div>
      <div class="coluna_interior_esq">
		<?php if (isset($messages) && is_array($messages) && sizeof($messages)>1 && $messages[1] == 1) {
			?>
			<img src="<?php echo $active_site['domain']; ?>/imgs/icone_ups160x150.png" width="160" height="150" alt="Embaixadores" />
			<?php
		} else {
			?>
			<img src="<?php echo $active_site['domain']; ?>/imgs/404.png" width="160" height="150" alt="Embaixadores" />
			<?php
		}
		?>
      </div>
      <div id="coluna2" class="coluna_interior_dir">
            <div id="topo_coluna2">
                  <div class="tituloTextosExtra">
				<?php
				if (isset($messages) && is_array($messages) && sizeof($messages)>1 && $messages[1] == 1) {
					echo _('Não está Login');
				} else {
					echo _('404');
				}
				?>
                  </div>    
            </div>
            <div class="texto3">
			<?php
			if (isset($messages) && is_array($messages)) {
				foreach ($messages as $message) {
					echo $message . '<br />';
				}
			} else {
				?>
				<p>
					<?php echo _("Ocorreu um erro inesperado, se o erro persistir contacte o administrador do site."); ?>
	                  </p>
				<?php
			}
			?>
                  <br/>
			<?php
			?>       
            </div>
      </div>
      <div class="clear"></div>
      <!--<div>
<?php
//if (isset($messages) && is_array($messages)) {
//	foreach ($messages as $message) {
//	    echo $message .'<br />';
//	}
//  }
?>
	</div>-->
</div>
