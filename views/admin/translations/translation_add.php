<?php
	$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST' action='". actionlink('TranslationController@translation_add',$active_pagemeta->id) . "'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('translation_add')) . "</div>";
	$content.="<div class='panel-body'>";
	$content.="<input type='hidden' name='form_action' value='translation_add'/>";
	
	//REFERENCE
	$content.="<div class='form-group'>";
	$content.="<label for='reference' class='col-md-4 control-label'>" . ucfirst(translate('reference')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='reference' id='reference' type='text' class='form-control' required/>";
	$content.="</div>";
	$content.="</div>";
	//END
	
	
	//type
	$content.="<div class='form-group'>";
	$content.="<label for='type' class='col-md-4 control-label'>" . ucfirst(translate('type')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<select name='type' id='type' class='form-control' required>";
	$content.="<option value='1'>" . translate('term') . "</option>";
	$content.="<option value='2'>" . translate('text') . "</option>";
	$content.="</select>";
	$content.="</div>";
	$content.="</div>";
	
	
	$languages = Language::all();
	
	foreach($languages as $language){
		
		//REFERENCE
		$content.="<div class='form-group'>";
		$content.="<label for='reference' class='col-md-4 control-label'>" . ucfirst(translate('translation')) . " " . $language->shortname . "</label>";
		$content.="<div class='col-md-6'>";
		$content.="<input name='translations[" . $language->id . "]' id='translations[" . $language->id . "]' type='text' class='form-control' required/>";
		$content.="</div>";
		$content.="</div>";
		//END
		
	}
	
	
		
	
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