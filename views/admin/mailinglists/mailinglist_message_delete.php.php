<?php
	if(isset($parameters[0])){
		$mailinglist_message_id=$parameters[0];
	}else{
		$mailinglist_message_id=0;
	}
	
	$mailinglist_message = MailinglistMessage::find($mailinglist_message_id);
	
	

$content.="<form role='form' method='post'>";
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";

	$content.="<div class='modal-body'>";

		$content.="<input type='hidden' name='form_action' value='mailinglist_message_delete'>";
		$content.="<input type='hidden' name='mailinglist_message_id' value='". $mailinglist_message->id .  "'>";
		$content.=translate('mailinglist_message_delete',TEXT);
				
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='submit' class='btn btn-danger'>". ucfirst(translate("yes")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("no")) . "</button>";
	$content.="</div>";
$content.="</form>";
       
?>