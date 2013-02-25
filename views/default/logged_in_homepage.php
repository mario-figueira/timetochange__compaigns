<?php
	$surveys_list_url = $this->build_action_url("survey", "list");
	$campaigns_list_url =  $this->build_action_url("campaign", "list");

	//$profile_url =   $active_site['domain'].'/'.$country['name'].'/profile';
	$profile_url = $this->build_action_url("profile", "default");
	
	$current_site_url = $active_site['domain'];
	
	//$profile_picture_url = $this->get_profile_image($ambassador);
	$default_img_name = 'foto_perfil_default.jpg';
	$user_img_url = '';
	
	$picture_name = $ambassador['picture_url'];
	$picture_name_is_set = isset($picture_name);
	$picture_physical_path = $this->build_uploaded_img_physical_path($picture_name);
	$picture_physicalfile_exists = file_exists($picture_physical_path);

	if ($picture_name_is_set && $picture_physicalfile_exists) { 
		$profile_picture_url = "{$current_site_url}/timthumb.php?src=/uploads/{$picture_name}&w=200&h=200";
	}else{
		$profile_picture_url = "{$current_site_url}/timthumb.php?src=/imgs/{$default_img_name}&w=200&h=200";
	}

	//$information_url = $active_site['domain'].'/'.$country['name'].'/info/instructions/id/'.$information_page_id;
	$information_url = $this->build_action_url("info", "instructions");
	     
	//$campaign1 = $campaigns_to_show[0];
	if($campaign1_to_show_exists){
		$campaign1 = $campaign1_to_show;
		$campaign1_id = $campaign1['id'];
		$campaign1_url = $this->build_action_url("campaign", "show", "campaign_id/{$campaign1_id}");
		$campaign1_title = $campaign1['display_name'];  //Campaign Samsung Galaxy SII
		$campaign1_text1 = $campaign1['description'];  //In this campaign 45 ambassadors are having the opportunity to try the new Samsung Galaxy SII for free.
		$campaign1_text2 = $campaign1['sub_description'];  //The ambassadors also had the opportunity to attend this smartphone’s launch event in LX Factory.
		$campaign1_img_url = $this->build_img_url($campaign1['home_site_img']);
	}
	
	if($campaign2_to_show_exists){
		//$campaign2 = $campaigns_to_show[1];
		$campaign2 = $campaign2_to_show;
		$campaign2_id	= $campaign2['id'];
		$campaign2_url	= $this->build_action_url("campaign", "show", "campaign_id/{$campaign2_id}");
		$campaign2_title	= $campaign1['display_name'];  //Campaign Samsung Galaxy SII
		$campaign2_text1	= $campaign1['description'];  //In this campaign 45 ambassadors are having the opportunity to try the new Samsung Galaxy SII for free.
		$campaign2_text2	= $campaign1['sub_description'];  //The ambassadors also had the opportunity to attend this smartphone’s launch event in LX Factory.
		$campaign2_img_url = $this->build_img_url($campaign2['home_site_img']);
	}	
	$no_campaigns_text = "no campaigns";
	
	$up_arrow_image_url =  $this->build_img_url("up.png");
	$ambassador_code = $ambassador['code'];
	
	
?>

		<div class="blocoNotificacoes">
                  <div class="blocoNotificacoesEsq">
                        <div class="ladoEsq">
                              <div class="blocoNotificacoesEsq1"><?php echo _('Campanhas'); ?></div>
                              <div class="blocoNotificacoesEsq2">
<!--
						<a href="<?php echo $campaigns_list_url; ?>"><?php echo _('Tens notificações novas! Clica aqui.'); ?> </a>
						<span class="notificacaoMenu2digitos extraTop2"><?php echo $unread_notifications_qnt; ?></span>
-->
					</div>
                              <div class="blocoNotificacoesEsq3" style="background-color:#FFFFFF">
						
<?php 
	$use_the_hardcoded_text_instead = true;
	if($use_the_hardcoded_text_instead){
		?>
						<table style="background-color: #FFFFFF; padding-top: 10px" border="1" boder-color="red">
							<tr style="vertical-align: top;">
								<td>
									<div class="image_transparent_background_container" style="height: auto;">
										<img src="<?php echo $this->build_img_url('icone_informacao_grande123x123.png');?>" alt=""/>
									</div>
								</td>
								<td style="padding-left: 35px;">
									<p class="tituloTextos">
									<?php echo _('default::logged_in_homepage::campaign_section_title The first campaigns are about to begin. Stay tuned to your email.')?></b>
									<p>
									<br />
									<br />
									<?php echo _('default::logged_in_homepage::campaign_section_line_1 Meanwhile:');?> 
									<br />
									<?php echo _('default::logged_in_homepage::campaign_section_line_2 - Keep your profile complete and  updated. With that you have more opportunities to be selected for campaigns that interest you;');?> 
									<br />
									<br />
									<?php echo _('default::logged_in_homepage::campaign_section_line_3 - Learn more about how to be an ambassador, with our training program;');?>
									<br />
									<br />
									<?php echo _('default::logged_in_homepage::campaign_section_line_4 - Start now spreading the word and recommending our community to your friends. You get points for each one that registers.');?>
									<br />
									<br />
									<?php echo _('default::logged_in_homepage::campaign_section_line_5 Good Luck!');?>
								</td>
							</tr>
						</table>
<?php 
	}else{
?>
						
<?php 
		if(!$campaigns_to_show_exists){ 
?>	
			<?php echo $no_campaigns_text; ?>
<?php 
		}
?>
						
						
<?php

		if($campaign1_to_show_exists){ 
?>						
						
                                    <a href="<?php echo $campaign1_url; ?>">
                                          <div class="blocoNotificacoesEsq3a">								
                                                <div class="blocoNotificacoesEsq3a1"><?php echo $campaign1_title; ?></div>
                                                <div class="blocoNotificacoesEsq3a2"><?php echo $campaign1_text1; ?></div>
                                                <div class="blocoNotificacoesEsq3a3"><?php echo $campaign1_text2; ?></div>
                                          </div>
                                          <div class="blocoNotificacoesEsq3b">
								<img src="<?php echo $campaign1_img_url; ?>" width="140" height="155">
							</div>
                                    </a>
<?php 
		}
?>							
                              </div>

                              <div class="blocoNotificacoesEsq3" style="background-color:#EEEEEE">
<?php 
		if($campaign2_to_show_exists){ 
?>						
                                    <a href="<?php echo $campaign2_url; ?>">
                                          <div class="blocoNotificacoesEsq3a">
                                                <div class="blocoNotificacoesEsq3a1"><?php echo $campaign2_title; ?></div>
                                                <div class="blocoNotificacoesEsq3a2"><?php echo $campaign2_text1; ?></div>
                                                <div class="blocoNotificacoesEsq3a3"><?php echo $campaign2_text2; ?></div>
                                          </div>
                                          <div class="blocoNotificacoesEsq3b">
								<img src="<?php echo $campaign2_img_url; ?>" width="140" height="155">
							</div>
                                    </a>
<?php 
		}
?>						
						
<?php 
	}
?>						
                              </div>
                        </div>				

                  </div>
                  <div class="blocoNotificacoesDir">
                        <div class="blocoNotificacoesDir1"><?php echo _('Perfil')?></div>
                        <div class="blocoNotificacoesDir2">
					<a href="<?php echo $profile_url;?>"><?php echo _('Completa o teu perfil.')?></a>
 					
					<span class="notificacaoMenu2digitos extraTop2">
						<?php echo $unfulfilled_surveys_qnt;?>
					</span>

				</div>
                        <div class="blocoNotificacoesDir3">
                              <div class="blocoNotificacoesDir3a">
                                          <img src="<?php echo $profile_picture_url;?>" width="200" height="200" alt="Foto de perfil" />
                              </div>
                              <div class="blocoNotificacoesDir3b"><span class="extraTexto"><?php echo _('O meu perfil')?></span>
                                    <div class="bt_tamanho4 floatRight">
                                          <a href="<?php echo $profile_url;?>" class="btContainer4">
                                                <div class="bt_tamanho4esq"></div>
                                                <div class="bt_tamanho4central"><?php echo _('Ver');?></div>
                                                <div class="bt_tamanho4dir"></div>
                                          </a>
                                    </div>
                              </div>
                              <div class="blocoNotificacoesDir3b"><span class="extraTexto"><?php echo _('Informação');?></span>
                                    <div class="bt_tamanho4 floatRight">
                                          <a href="<?php echo $information_url;?>" class="btContainer4">
                                                <div class="bt_tamanho4esq"></div>
                                                <div class="bt_tamanho4central"><?php echo _('Ver');?></div>
                                                <div class="bt_tamanho4dir"></div>
                                          </a>
                                    </div>
                              </div>
                              <div class="blocoNotificacoesDir3c"><?php echo _('Pontos totais');?> <?php echo $point;?></div>
                              <div class="blocoNotificacoesDir3c"><?php echo _('Nível ');?><?php echo $user_level;?>&nbsp;<img src="<?php echo $up_arrow_image_url;?>" alt="Up" width="20" height="22" align="absmiddle"></div>
                              <div class="blocoNotificacoesDir3c"><?php echo _('Código:');?> <?php echo $ambassador_code;?></div>
                        </div>
                  </div>
            </div>