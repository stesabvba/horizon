<?php
	if(isset($parameters[0])){
		$mailinglist_member_id=$parameters[0];
	}else{
		$mailinglist_member_id=0;
	}
	
	$mailinglistmember = Mailinglistmember::find($mailinglist_member_id);
	
	

$content.="<form role='form' method='post'>";
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";

	$content.="<div class='modal-body'>";

		$content.="<input type='hidden' name='form_action' value='mailinglist_member_delete'>";
		$content.="<input type='hidden' name='mailinglist_member_id' value='". $mailinglistmember->id .  "'>";
		$content.=translate('mailinglist_member_delete',TEXT);
				
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='submit' class='btn btn-danger'>". ucfirst(translate("yes")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("no")) . "</button>";
	$content.="</div>";
$content.="</form>";
       
?>