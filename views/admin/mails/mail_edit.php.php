<?php

	if(isset($parameters[0])){
		$mail_id=$parameters[0];
	}else{
		$mail_id=0;
	}
	
	$mail = Mail::find($mail_id);
	
	$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('mail_edit')) . "</div>";
	$content.="<div class='panel-body'>";
	$content.="<input type='hidden' name='form_action' value='mail_edit'/>";
	$content.="<input type='hidden' name='mail_id' value='$mail_id'/>";
	//to
	$content.="<div class='form-group'>";
	$content.="<label for='to' class='col-md-1 control-label'>" . ucfirst(translate('to')) . "</label>";
	$content.="<div class='col-md-11'>";
	$content.="<input name='to' id='to' type='email' class='form-control' value='" . $mail->to . "' required/>";
	$content.="</div>";
	$content.="</div>";
	//to
	
	//cc
	$content.="<div class='form-group'>";
	$content.="<label for='cc' class='col-md-1 control-label'>" . ucfirst(translate('cc')) . "</label>";
	$content.="<div class='col-md-11'>";
	$content.="<input name='cc' id='cc' type='email' class='form-control' value='" . $mail->cc . "'/>";
	$content.="</div>";
	$content.="</div>";
	//cc
	
	//bcc
	$content.="<div class='form-group'>";
	$content.="<label for='bcc' class='col-md-1 control-label'>" . ucfirst(translate('bcc')) . "</label>";
	$content.="<div class='col-md-11'>";
	$content.="<input name='bcc' id='bcc' type='email' class='form-control' value='" . $mail->bcc . "'/>";
	$content.="</div>";
	$content.="</div>";
	//bcc
	
	//subject
	$content.="<div class='form-group'>";
	$content.="<label for='bcc' class='col-md-1 control-label'>" . ucfirst(translate('subject')) . "</label>";
	$content.="<div class='col-md-11'>";
	$content.="<input name='subject' id='subject' type='text' class='form-control' value='" . $mail->subject . "'/>";
	$content.="</div>";
	$content.="</div>";
	//subject

	//LANGUAGE
	$content.="<div class='form-group'>";
	$content.="<label for='parent_id' class='col-md-1 control-label'>" . ucfirst(translate('language')) . "</label>";
	$content.="<div class='col-md-11'>";
	$content.="<select name='language_id' id='language_id' class='form-control' required>";
	$content.="<option></option>";
	$languages = Language::all();
	foreach($languages as $language){
		if($language->id == $mail->language_id){
			$content.="<option value='" . $language->id . "' selected>" . $language->name . "</option>";
		}else{
			$content.="<option value='" . $language->id . "'>" . $language->name . "</option>";
		}
		
	}
	
	$content.="</select>";
	$content.="</div>";
	$content.="</div>";
	//END 
	
	//content
	$content.="<div class='form-group'>";
	$content.="<label for='content' class='col-md-1 control-label'>" . ucfirst(translate('content')) . "</label>";
	$content.="<div class='col-md-11'>";
	$content.="<textarea id='content' name='content' class='wysiwyg'>" . $mail->content . "</textarea>";
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