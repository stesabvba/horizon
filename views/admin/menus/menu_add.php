<?php

$actionlink = actionlink('MenuController@menu_add');

$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST' action='$actionlink'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('menu_add')) . "</div>";
	$content.="<div class='panel-body'>";
		
	//REFERENCE
	$content.="<div class='form-group'>";
	$content.="<label for='name' class='col-md-1 control-label'>" . ucfirst(translate('name')) . "</label>";
	$content.="<div class='col-md-11'>";
	$content.="<input name='name' id='name' type='text' class='form-control' required/>";
	$content.="</div>";
	$content.="</div>";
	//END
	
	
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-11 col-md-offset-1'>";
	$content.="<button type='submit' class='btn btn-default'>" . ucfirst(translate("add")) . "</button>";
	$content.="</div>";
	$content.="</div>";
	
	$content.=("</div>");
	$content.=("</div>");
	$content.=("</div>");
	$content.="</form>";

?>