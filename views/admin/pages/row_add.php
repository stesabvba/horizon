<?php
	if(isset($parameters[0])){
		$page_meta_id=$parameters[0];
	}else{
		$page_meta_id=0;
	}
	
	$content.="<div class='modal-dialog modal-lg' id='modal-dialog' role='document'>";
	$content.="<div class='modal-content'>";	


$content.="<form role='form' method='post'>";
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";

	$content.="<div class='modal-body'>";

		$content.="<input type='hidden' name='form_action' value='row_add'>";
		$content.="<input type='hidden' name='page_meta_id' value='". $page_meta_id .  "'>";
		$content.=translate('row_add',TEXT);
				
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='submit' class='btn btn-danger'>". ucfirst(translate("yes")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("no")) . "</button>";
	$content.="</div>";
$content.="</form>";

	$content.="</div>";	
	$content.="</div>";
       
?>