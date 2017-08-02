<?php
	if(isset($parameters[0])){
		$mailinglist_id=$parameters[0];
	}else{
		$mailinglist_id=0;
	}
	
	$mailinglist = Mailinglist::find($mailinglist_id);
	
	if($mailinglist==null){
		header("Location:" . pagelink("mailinglists",$language_id));
	}

$content.="<form role='form' method='post'>";
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";

	$content.="<div class='modal-body'>";

		$content.="<input type='hidden' name='form_action' value='mailinglist_delete'>";
		$content.="<input type='hidden' name='mailinglist_id' value='". $mailinglist->id .  "'>";
		$content.=translate('mailinglist_delete',TEXT);
				
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='submit' class='btn btn-danger'>". ucfirst(translate("yes")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("no")) . "</button>";
	$content.="</div>";
$content.="</form>";
       
?>