<?php

	if(isset($parameters[0])){
		$migration=$parameters[0];
	}else{
		$migration="";
	}
	
	$migrationcontent = file_get_contents('migrations/' . $migration . '.php');
	
	$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST' action='". actionlink('MigrationController@migration_edit',$active_pagemeta->id) . "'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('migration_edit')) . "</div>";
	$content.="<div class='panel-body'>";
	
	$content.="<input type='hidden' name='migration' value='$migration'/>";

	
	//content
	$content.="<div class='form-group'>";
	$content.="<label for='content' class='col-md-1 control-label'>" . ucfirst(translate('content')) . "</label>";
	$content.="<div class='col-md-11'>";
	$content.="<textarea id='content' name='content' rows='20' style='width: 100%;'>$migrationcontent</textarea>";
	$content.="</div>";
	$content.="</div>";
	//content
	
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-11 col-md-offset-1'>";
	$content.="<button type='submit' class='btn btn-primary'><i class='fa fa-btn fa-sign-in'></i> " . ucfirst(translate("update")) . "</button>";
	$content.="</div>";
	$content.="</div>";
	
	$content.=("</div>");
	$content.=("</div>");
	$content.=("</div>");
	$content.="</form>";
?>
