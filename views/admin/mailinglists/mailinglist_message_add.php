<?php

	if(isset($parameters[0])){
		$mailinglist_id=$parameters[0];
	}else{
		$mailinglist_id=0;
	}
	
	$mailinglist = Mailinglist::find($mailinglist_id);
	
	if($mailinglist==null){
		header("Location:" . pagelink("mailinglists",$language_id));
	}
	
	
		
$content.="<form id='' class='form-horizontal' role='form' data-toggle='validator' method='POST'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('mailinglist_message_add')) . "</div>";
	$content.="<div class='panel-body'>";
	$content.="<input type='hidden' name='form_action' value='mailinglist_message_add'>";
	$content.="<input type='hidden' name='mailinglist_id' value='". $mailinglist->id . "'>";
	
	//name
	$content.="<div class='form-group'>";
	$content.="<label for='name' class='col-md-1 control-label'>" . ucfirst(translate('name')) . "</label>";
	$content.="<div class='col-md-11'>";
	$content.="<input name='name' id='name' type='text' class='form-control' required/>";
	$content.="</div>";
	$content.="</div>";
	//name
	$content.="<div class='form-group'>";
	$content.="<label for='name' class='col-md-1 control-label'>" . ucfirst(translate('content')) . "</label>";
	$content.="<div class='col-md-11'>";
	$content.="<ul class='nav nav-tabs'>";
	$count = 0;
	$languages = Language::all();
	foreach($languages as $language){
		if($language->id==$language_id){
			$content.="<li class='active'><a class='' data-toggle='tab' href='#message_". $language->shortname . "'>" . ucfirst(translate('message_content')) . " " . $language->shortname . "</a></li>";
		}else{
			$content.="<li><a class='' data-toggle='tab' href='#message_" . $language->shortname . "'>" . ucfirst(translate('message_content')) . " " . $language->shortname . "</a></li>";
		}
		$count++;
	}
	$content.="</ul>";
	$content.="<div class='tab-content' >";
	foreach($languages as $language){
		
		
		if($language->id==$language_id){
			$content.="<div id='message_" . $language->shortname . "' class='tab-pane fade in active'>";
		}else{
			$content.="<div id='message_" . $language->shortname . "' class='tab-pane fade'>";
		}
		
		$content.="<div>";
			$content.="<label for='name' class='form-control-label'>" . ucfirst(translate('subject')) . " " . $language->shortname . ":</label>";
			$content.="<input type='text' name='subject[". $language->id . "]' class='form-control' required>";
		$content.="</div>";
		$content.="<div>";
			$content.="<label for='content' class='form-control-label'>" . ucfirst(translate('content')) . " " . $language->shortname . ":</label>";
		$content.="<textarea id='content' name='content[" . $language->id . "]' class='wysiwyg'></textarea>";
		$content.="</div>";
		$content.="</div>";
		
		
	}
		$content.="</div>";
	
	$content.="</div>";	
	$content.="</div>";

	
	
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