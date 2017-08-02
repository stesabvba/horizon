<?php

	$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('language_add')) . "</div>";
	$content.="<div class='panel-body'>";
	$content.="<input type='hidden' name='form_action' value='language_add'/>";
	
	//name
	$content.="<div class='form-group'>";
	$content.="<label for='name' class='col-md-4 control-label'>" . ucfirst(translate('name')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='name' id='name' type='text' class='form-control' required/>";
	$content.="</div>";
	$content.="</div>";
	//end
	
	//shortname
	$content.="<div class='form-group'>";
	$content.="<label for='shortname' class='col-md-4 control-label'>" . ucfirst(translate('shortname')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='shortname' id='shortname' type='text' class='form-control' required/>";
	$content.="</div>";
	$content.="</div>";
	//end
	

	
	
	//ACTIVE
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
    $content.="<div class='checkbox'>";
	$content.="<label><input type='checkbox' name='active' id='active' checked/>" . ucfirst(translate('language_active')) . "</label>";
	$content.="</div>";
   	$content.="</div>";
	$content.="</div>";
	//END 
	

	
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
	$content.="<button type='submit' class='btn btn-primary'><i class='fa fa-btn fa-sign-in'></i> " . ucfirst(translate("add")) . "</button>";
	$content.="</div>";
	$content.="</div>";
	
	$content.=("</div>");
	$content.=("</div>");
	$content.=("</div>");
	$content.="</form>";
?>