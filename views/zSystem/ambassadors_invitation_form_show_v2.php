<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
<?php
?>
<div class="center_main">

	<h2>List of Ambassadors to invite from</h2>
<table>
	<tr>
		<td>
			id
		</td>
		<td>
			email
		</td>
		<td>
			name
		</td>
		<td>
			registration status
		</td>
		<td>
			invitation status
		</td>
		<td>
			actions
		</td>
	</tr>
	
<?php

	foreach($ambassadors as $ambassador){
		$ambassador_id =  $ambassador['id'];
		
		$invitation_status = $ambassador['invitation_status'];
		$invitation_status = empty($invitation_status)?0:$invitation_status;
		
		$is_not_invited = ($invitation_status==0);
		$show_invite_button = $is_not_invited;
		$invitation_status_text = ($invitation_status==0)?"not_invited":"";
		$invitation_status_text = ($invitation_status==1)?"invited (unconfirmed, no mail sended)":$invitation_status_text;
		$invitation_status_text = ($invitation_status==2)?"invited (unconfirmed, mail sended)":$invitation_status_text;
		$invitation_status_text = ($invitation_status==3)?"invited (invitation rejected)":$invitation_status_text;
		$invitation_status_text = ($invitation_status==4)?"invited (campaign terms rejected)":$invitation_status_text;		
		$invitation_status_text = ($invitation_status==5)?"invited (confirmed)":$invitation_status_text;
?>
	<tr>
		<td>
			<?php echo $ambassador_id; ?>
		</td>
		<td>
			<?php echo $ambassador['email']; ?>
		</td>
		<td>
			<?php echo "{$ambassador['first_name']} {$ambassador['last_name']}" ; ?>
		</td>
		<td>
			<?php echo "{$ambassador['registration_status']}" ; ?>
		</td>
		<td>
			<?php echo "{$invitation_status} ({$invitation_status_text})" ; ?>
			
		</td>
		<td>
<?php 
	if($show_invite_button){
		$invite_action_url = $this->build_action_url("zSystem", "mark_ambassador_for_inviation", "ambassador_id/{$ambassador_id}/campaign_id/{$campaign_id}");
?>
	
			<a href="<?php echo $invite_action_url; ?>">invite</a>
<?php
	}
?>
		</td>
	</tr>
<?	
	
	}
?>

</table>	
	
	
	<div>
<?php
		$send_pending_invitations_now_action_url = $this->build_action_url("zSystem", "send_pending_invitation_mails", "campaign_id/{$campaign_id}");
?>
			<a href="<?php echo $send_pending_invitations_now_action_url; ?>">send pending invitations now</a>		
	</div>
</div>