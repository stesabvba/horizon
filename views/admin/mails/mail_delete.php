<?php

	if(isset($parameters[0])){
		$mail_id=$parameters[0];
	}else{
		$mail_id=0;
	}
	
	$mail = Mail::find($mail_id);
	
	if($mail==null){
		
		header('Location: ' . pagelink('mails',$language_id));
		
	}
	
	$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('mail_delete')) . "</div>";
	$content.="<div class='panel-body'>";
	$content.="<input type='hidden' name='form_action' value='mail_delete'/>";
	$content.="<input type='hidden' name='mail_id' value='" . $mail_id . "'/>";
	
	$content.="<div class='col-md-12'>";
	$content.="<p>" . translate("delete_mail") . "</p>";
	$content.="</div>";
	
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-12'>";
	$content.="<button type='submit' class='btn btn-danger'><i class='glyphicon glyphicon-remove'></i> " . ucfirst(translate("yes")) . "</button>";
	$content.=" <button onclick='window.history.back();' class='btn btn-primary'><i class='fa fa-btn fa-sign-in'></i> " . ucfirst(translate("no")) . "</button>";
	$content.="</div>";

	$content.="</div>";
	
	$content.=("</div>");
	$content.=("</div>");
	$content.=("</div>");
	$content.="</form>";
?>