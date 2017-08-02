<?php
	if(isset($parameters[0])){
		$row_id=$parameters[0];
	}else{
		$row_id=0;
	}
	
	$row = Row::find($row_id);


$content.="<form role='form' method='post'>";
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";

	$content.="<div class='modal-body'>";

		$content.="<input type='hidden' name='form_action' value='row_delete'>";
		$content.="<input type='hidden' name='row_id' value='". $row->id .  "'>";
		$content.=translate('row_delete',TEXT);
				
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='submit' class='btn btn-danger'>". ucfirst(translate("yes")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("no")) . "</button>";
	$content.="</div>";
$content.="</form>";
       
?>