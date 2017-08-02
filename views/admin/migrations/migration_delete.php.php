<?php
	if(isset($parameters[0])){
		$migration=$parameters[0];
	}else{
		$migration="";
	}

	$content.="<form role='form' method='post' action='". actionlink('MigrationController@migration_delete',$active_pagemeta->id) . "'>";
	
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";

	$content.="<div class='modal-body'>";

		$content.="<input type='hidden' name='migration' value='". $migration .  "'>";
		$content.=translate('migration_delete',TEXT);
				
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='submit' class='btn btn-danger'>". ucfirst(translate("yes")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("no")) . "</button>";
	$content.="</div>";
$content.="</form>";
       
?>