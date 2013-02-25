<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
<body class="temaPaises">
	<div class="main">
		<div class="protegerRodape">
			<div class="header_paises">
				<div class="link_home header_extra">
					<a href="#"><?php echo _('Ambassadors.com'); ?></a>
				</div>
				<div class="assinatura_paises"><?php echo _('word-of-mouth marketing');?></div>
			</div>
			<div class="center_main_paises">
				<div class="center_main_paises1"><?php echo 'Where do you live:'; ?></div>
				<div class="center_main_paises2">
<?php
					foreach ($available_communities_to_choose_from as $community) {
						$commnunity_name = $community['name'];
						$commnity_url = $community['url'] . '/' . $commnunity_name;
						$commnunity_name_lowercase = strtolower($commnunity_name);
						$commnunity_image_url = $active_site['domain'] ."/imgs/paises_inicio/{$commnunity_name_lowercase}.png";
						
						$commnunity_printable_name = $community['printable_name'];
						
?>
						<div class="center_main_paises2a">
							<a href="<?php echo $commnity_url; ?>">
								<img src="<?php echo $commnunity_image_url; ?>" alt="<?php echo $commnunity_printable_name;  ?>"> </a>
						</div>
<?php 
					}
?>
				</div>
			</div>
		</div>
	</div>