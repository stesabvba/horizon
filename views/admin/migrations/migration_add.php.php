<?php

	$content.="<form role='form' method='post' action='". actionlink('MigrationController@migration_add',$active_pagemeta->id) . "'>";
	
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";
	$content.="<div class='modal-body'>";
		$content.="<div class='form-group'>";
		$content.="<label for='name' class='control-label'>" . ucfirst(translate('name')) . "</label>";
		$content.="<input type='text' class='form-control' name='name' id='name' required>";
		$content.="</div>";
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='submit' class='btn btn-primary'>". ucfirst(translate("add")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("close")) . "</button>";
	$content.="</div>";
$content.="</form>";
       
?>