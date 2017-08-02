<?php


$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST'>";
$content.="<div class='panel panel-default'>";
$content.="<div class='panel-heading'>" . ucfirst(translate('mail_template_edit')) . "</div>";
$content.="<div class='panel-body'>";
$content.="<input type='hidden' name='form_action' value='mail_template_add'/>";

//Title
$content.="<div class='form-group'>";
$content.="<label for='filename' class='col-md-1 control-label'>" . ucfirst(translate('title')) . "</label>";
$content.="<div class='col-md-11'>";
$content .= "<input type='text' name='template_file_name' />";
$content.="</div>";
$content.="</div>";
//title

//content
$content.="<div class='form-group'>";
$content.="<label for='content' class='col-md-1 control-label'>" . ucfirst(translate('content')) . "</label>";
$content.="<div class='col-md-11'>";
$content .= "<textarea class='wysiwyg' name='template_file_html'></textarea>";
$content.="</div>";
$content.="</div>";
//content
	



$content.="<div class='form-group'>";
$content.="<div class='col-md-11 col-md-offset-1'>";
$content.="<button type='submit' class='btn btn-primary'><i class='fa fa-btn fa-sign-in'></i> " . ucfirst(translate("add")) . "</button>";
$content.="</div>";
$content.="</div>";
	
$content.=("</div>");
$content.=("</div>");
$content.=("</div>");
$content.="</form>";

?>