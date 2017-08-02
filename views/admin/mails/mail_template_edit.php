<?php

if(isset($parameters[0])){
	$file_name=$parameters[0];
}

$file_content = file_get_contents(__DIR__ . "/../../../tinymce_templates/".$file_name.".html");

$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST'>";
$content.="<div class='panel panel-default'>";
$content.="<div class='panel-heading'>" . ucfirst(translate('mail_template_edit')) . "</div>";
$content.="<div class='panel-body'>";
$content.="<input type='hidden' name='form_action' value='mail_template_edit'/>";
$content.="<input type='hidden' name='template_file' value='$file_name'/>";

//content
$content.="<div class='form-group'>";
$content.="<label for='content' class='col-md-1 control-label'>" . ucfirst(translate('content')) . "</label>";
$content.="<div class='col-md-11'>";
$content .= "<textarea class='wysiwyg' name='template_file_html'>".$file_content."</textarea>";
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