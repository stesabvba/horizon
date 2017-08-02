<?php

if(isset($parameters[0])){
	$file_name=$parameters[0];
}

$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST'>";
$content.="<div class='panel panel-default'>";
$content.="<div class='panel-heading'>" . ucfirst(translate('mail_template_delete')) . "</div>";
$content.="<div class='panel-body'>";
$content.="<input type='hidden' name='form_action' value='mail_template_delete'/>";
$content.="<input type='hidden' name='template_file_name' value='$file_name'/>";

$content.="<div class='form-group'>";
$content.="<div class='col-md-11 col-md-offset-1'>";
$content.="<h3>".translate("modal_mail_template_delete_message")."</h3>";
$content.="</div>";
$content.="</div>";



$content.="<div class='form-group'>";
$content.="<div class='col-md-11 col-md-offset-1'>";
$content.="<button type='submit' class='btn btn-danger'><i class='fa fa-btn fa-trash'></i> " . ucfirst(translate("delete")) . "</button>";
$content.="</div>";
$content.="</div>";
	
$content.=("</div>");
$content.=("</div>");
$content.=("</div>");
$content.="</form>";

?>