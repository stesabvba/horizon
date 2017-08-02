<?php
	if(isset($parameters[0])){
		$row_content_id=$parameters[0];
	}else{
		$row_content_id=0;
	}
	
	


$content.="<form role='form' method='post'>";
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";

	$content.="<div class='modal-body'>";

		$content.="<input type='hidden' name='form_action' value='row_content_delete'>";
		$content.="<input type='hidden' name='row_content_id' value='". $row_content_id .  "'>";
		$content.=translate('row_content_delete',TEXT);
				
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='submit' class='btn btn-danger'>". ucfirst(translate("yes")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("no")) . "</button>";
	$content.="</div>";
$content.="</form>";
       
?>