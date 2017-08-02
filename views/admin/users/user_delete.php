<?php
	if(isset($parameters[0])){
		$user_id=$parameters[0];
	}else{
		$user_id=0;
	}

	$content.="<form role='form' method='post' action='". pagelink('user_delete',$language_id,'POST','UserController@user_delete') . "'>";
	
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";

	$content.="<div class='modal-body'>";

		$content.="<input type='hidden' name='user_id' value='". $user_id .  "'>";
		$content.=translate('delete_user',TEXT);
				
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='submit' class='btn btn-danger'>". ucfirst(translate("yes")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("no")) . "</button>";
	$content.="</div>";
$content.="</form>";
       
?>